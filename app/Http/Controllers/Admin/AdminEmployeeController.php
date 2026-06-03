<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminEmployeeController extends Controller
{
    /**
     * Display a listing of the employees (admins).
     */
    public function index()
    {
        $employees = User::where('role', 'admin')->orderBy('id', 'desc')->get();
        return view('admin.employees.index', compact('employees'));
    }

    /**
     * Store a newly created employee.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', Rules\Password::defaults()],
            'shift_start' => ['required', 'date_format:H:i'],
            'shift_end' => ['required', 'date_format:H:i'],
            'face_features' => ['nullable', 'string'], // Receives biometric descriptor string
        ]);

        // Default vector descriptor if face scan skipped in registration
        $faceFeatures = $request->face_features;
        if (!$faceFeatures || empty(json_decode($faceFeatures, true))) {
            $faceFeatures = json_encode(array_fill(0, 128, 0.1));
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'admin',
            'shift_start' => $request->shift_start,
            'shift_end' => $request->shift_end,
            'face_features' => $faceFeatures,
        ]);

        return redirect()->route('admin.employees.index')->with('success', 'Karyawan / Admin baru berhasil ditambahkan.');
    }

    /**
     * Update the specified employee in storage.
     */
    public function update(Request $request, $id)
    {
        $employee = User::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $employee->id],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['nullable', Rules\Password::defaults()],
            'shift_start' => ['required', 'date_format:H:i'],
            'shift_end' => ['required', 'date_format:H:i'],
            'face_features' => ['nullable', 'string'],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'shift_start' => $request->shift_start,
            'shift_end' => $request->shift_end,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->filled('face_features')) {
            $faceData = json_decode($request->face_features, true);
            if (is_array($faceData) && count($faceData) === 128) {
                $data['face_features'] = $request->face_features;
            }
        }

        $employee->update($data);

        return redirect()->route('admin.employees.index')->with('success', 'Data Karyawan berhasil diperbarui.');
    }

    /**
     * Remove the employee from storage.
     */
    public function destroy($id)
    {
        $employee = User::findOrFail($id);
        
        // Prevent deleting self
        if ($employee->id === auth()->id()) {
            return redirect()->route('admin.employees.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif.');
        }

        $employee->delete();

        return redirect()->route('admin.employees.index')->with('success', 'Karyawan berhasil dihapus.');
    }

    /**
     * Detect face and return descriptor array.
     */
    public function detectFace(Request $request)
    {
        $request->validate([
            'image' => 'required|string',
            'simulate' => 'nullable|boolean'
        ]);

        if ($request->input('simulate')) {
            $descriptor = array_fill(0, 128, 0.1);
            return response()->json([
                'status' => 'success',
                'descriptor' => $descriptor,
                'message' => 'Simulated descriptor successfully generated!'
            ]);
        }

        try {
            $descriptor = $this->getDescriptorFromImage($request->input('image'));
            return response()->json([
                'status' => 'success',
                'descriptor' => $descriptor
            ]);
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            if (str_contains($msg, 'ModuleNotFoundError') || str_contains($msg, 'No module named')) {
                // Fallback to simulated descriptor in development environment
                $descriptor = array_fill(0, 128, 0.1);
                return response()->json([
                    'status' => 'success',
                    'descriptor' => $descriptor,
                    'warning' => "Python 'face_recognition' library is not installed. Using simulated vector (0.1 filled)."
                ]);
            }
            return response()->json([
                'status' => 'error',
                'message' => $msg
            ], 422);
        }
    }

    /**
     * Decode base64 image, invoke python face-recognition, extract descriptor
     */
    private function getDescriptorFromImage($base64Image)
    {
        if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
            $base64Image = substr($base64Image, strpos($base64Image, ',') + 1);
        }

        $imageData = base64_decode($base64Image);
        if ($imageData === false) {
            throw new \Exception('Data Base64 gambar tidak valid.');
        }

        // Create a temporary file
        $tempDir = sys_get_temp_dir();
        $tempFile = $tempDir . DIRECTORY_SEPARATOR . 'face_scan_' . uniqid() . '.jpg';
        file_put_contents($tempFile, $imageData);

        $scriptPath = base_path('scripts/detect_faces.py');
        $escapedTempFile = escapeshellarg($tempFile);

        // Try executing using python
        $command = "python " . escapeshellarg($scriptPath) . " " . $escapedTempFile . " 2>&1";
        $output = shell_exec($command);

        // Fallback to python3 if output is empty
        if (empty($output)) {
            $command = "python3 " . escapeshellarg($scriptPath) . " " . $escapedTempFile . " 2>&1";
            $output = shell_exec($command);
        }

        // Clean up
        if (file_exists($tempFile)) {
            @unlink($tempFile);
        }

        if (empty($output)) {
            throw new \Exception('Skrip Python tidak merespon.');
        }

        $result = json_decode($output, true);
        if (!$result) {
            if (str_contains($output, 'ModuleNotFoundError') || str_contains($output, 'No module named')) {
                throw new \Exception('ModuleNotFoundError: ' . trim($output));
            }
            throw new \Exception('Format output deteksi tidak valid: ' . trim($output));
        }

        if (isset($result['error'])) {
            throw new \Exception($result['error']);
        }

        if (!isset($result['embeddings']) || empty($result['embeddings'])) {
            throw new \Exception('Wajah tidak terdeteksi dalam foto. Posisikan wajah Anda tegak di depan kamera dengan pencahayaan cukup.');
        }

        return $result['embeddings'][0];
    }
}
