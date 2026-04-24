<?php
try {
    $user = \App\Models\User::create([
        'name' => 'test_user',
        'username' => 'test_user',
        'email' => 'test@test.com',
        'password' => bcrypt('123456'),
        'role' => 'siswa',
        'status' => 'active'
    ]);
    echo "Success: User created with ID " . $user->id . "\n";
    
    // Check if password works
    $isValid = \Illuminate\Support\Facades\Hash::check('123456', $user->password);
    echo "Password check: " . ($isValid ? "Valid" : "Invalid") . "\n";
    
} catch(\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
