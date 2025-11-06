<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-sm">
        <h2 class="text-2xl font-bold mb-4 text-center">Lupa Password</h2>
        <p class="text-center text-gray-600 mb-6">
            Masukkan email Anda. Kami akan mengirimkan 4-digit OTP ke email tersebut.
        </p>

        <form id="otpForm">
            
            <div id="notification" class="hidden p-4 rounded mb-4"></div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                <input type="email" id="email" name="email" required
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <button type="submit" id="submitButton"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Kirim OTP
            </button>
        </form>

        <div class="text-center mt-4">
            <a href="{{ route('employee.login') }}" class="text-sm text-indigo-600 hover:text-indigo-500">
                Kembali ke Login
            </a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('otpForm');
            const button = document.getElementById('submitButton');
            const notification = document.getElementById('notification');
            const emailField = document.getElementById('email');

            form.addEventListener('submit', function (e) {
                e.preventDefault(); // Hentikan submit form standar
                
                button.disabled = true;
                button.textContent = 'Mengirim...';
                notification.classList.add('hidden');

                axios.post('/api/otp/send', {
                    email: emailField.value
                })
                .then(response => {
                    // SUKSES: Tampilkan notifikasi yang Anda minta
                    notification.className = 'p-4 rounded mb-4 bg-green-100 text-green-700';
                    notification.textContent = 'Cek gmail anda untuk OTP!';
                    notification.classList.remove('hidden');
                    
                    button.disabled = false;
                    button.textContent = 'Kirim OTP';
                })
                .catch(error => {
                    // GAGAL: Tampilkan error
                    let message = 'Terjadi kesalahan.';
                    if (error.response && error.response.data && error.response.data.errors) {
                        message = error.response.data.errors.email[0]; // Ambil pesan error validasi
                    } else if (error.response && error.response.data && error.response.data.message) {
                        message = error.response.data.message;
                    }

                    notification.className = 'p-4 rounded mb-4 bg-red-100 text-red-700';
                    notification.textContent = message;
                    notification.classList.remove('hidden');

                    button.disabled = false;
                    button.textContent = 'Kirim OTP';
                });
            });
        });
    </script>
</body>
</html>