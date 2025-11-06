<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-sm">
        <h2 class="text-2xl font-bold mb-6 text-center">Buat Password Baru</h2>

        <form id="resetForm">

            <div id="notification" class="hidden p-4 rounded mb-4"></div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" readonly
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-100">
            </div>

            <div class="mb-4">
                <label for="otp" class="block text-sm font-medium text-gray-700">Kode OTP (4 Digit)</label>
                <input type="text" id="otp" name="otp" required maxlength="4"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                <input type="password" id="password" name="password" required
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <button type="submit" id="submitButton"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Simpan Password Baru
            </button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('resetForm');
            const button = document.getElementById('submitButton');
            const notification = document.getElementById('notification');
            const emailField = document.getElementById('email');

            // Ambil email dari URL dan isi otomatis
            const urlParams = new URLSearchParams(window.location.search);
            const emailFromUrl = urlParams.get('email');
            if (emailFromUrl) {
                emailField.value = emailFromUrl;
            }

            form.addEventListener('submit', function (e) {
                e.preventDefault();
                button.disabled = true;
                button.textContent = 'Menyimpan...';
                notification.classList.add('hidden');

                const formData = {
                    email: document.getElementById('email').value,
                    otp: document.getElementById('otp').value,
                    password: document.getElementById('password').value,
                    password_confirmation: document.getElementById('password_confirmation').value,
                };

                axios.post('/api/otp/reset', formData)
                .then(response => {
                    // SUKSES
                    notification.className = 'p-4 rounded mb-4 bg-green-100 text-green-700';
                    notification.textContent = 'Password berhasil direset! Anda akan diarahkan ke halaman login.';
                    notification.classList.remove('hidden');
                    
                    // Sembunyikan form
                    form.classList.add('hidden');

                    // Arahkan kembali ke login setelah 3 detik
                    setTimeout(() => {
                        window.location.href = "{{ route('employee.login') }}";
                    }, 3000);
                })
                .catch(error => {
                    // GAGAL
                    let message = 'Terjadi kesalahan.';
                    if (error.response && error.response.data && error.response.data.message) {
                        message = error.response.data.message;
                    } else if (error.response && error.response.data && error.response.data.errors) {
                        // Menangani error validasi
                        message = Object.values(error.response.data.errors).join(' ');
                    }

                    notification.className = 'p-4 rounded mb-4 bg-red-100 text-red-700';
                    notification.textContent = message;
                    notification.classList.remove('hidden');

                    button.disabled = false;
                    button.textContent = 'Simpan Password Baru';
                });
            });
        });
    </script>
</body>
</html>