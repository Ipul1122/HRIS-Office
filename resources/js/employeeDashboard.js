
window.copyToClipboard = function() {
    const codeElement = document.getElementById('securityCode');
    const messageBox = document.getElementById('copyMessage');

    if (!codeElement) {
        console.error('Elemen kode tidak ditemukan!');
        return;
    }

    const codeText = codeElement.innerText.trim();

    // Cara 1: Menggunakan Clipboard API (Modern & Aman)
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(codeText).then(() => {
            showSuccess();
        }).catch(err => {
            console.warn('Clipboard API gagal, mencoba metode alternatif...', err);
            fallbackCopy(codeText);
        });
    } else {
        // Cara 2: Metode Fallback (Untuk browser lama atau HTTP biasa)
        fallbackCopy(codeText);
    }

    function showSuccess() {
        if (messageBox) {
            messageBox.classList.remove('hidden');
            setTimeout(() => {
                messageBox.classList.add('hidden');
            }, 2000);
        }
    }

    function fallbackCopy(text) {
        const textArea = document.createElement("textarea");
        textArea.value = text;
        
        // Sembunyikan textarea dari tampilan agar tidak merusak layout
        textArea.style.position = "fixed";
        textArea.style.left = "-9999px";
        textArea.style.top = "0";
        
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();

        try {
            const successful = document.execCommand('copy');
            if (successful) {
                showSuccess();
            } else {
                alert('Gagal menyalin kode. Silakan salin secara manual.');
            }
        } catch (err) {
            console.error('Fallback error:', err);
            alert('Browser tidak mendukung fitur salin otomatis.');
        }

        document.body.removeChild(textArea);
    }
};