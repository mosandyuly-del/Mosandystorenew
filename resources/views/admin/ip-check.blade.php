<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek IP Server Digiflazz - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-bold text-gray-800 mb-4">IP Outbound Server Railway</h2>
        <p class="text-gray-600 mb-6 text-sm">
            Gunakan IP di bawah ini untuk di daftarkan pada menu <strong>IP Whitelist</strong> di Dashboard Digiflazz kamu.
        </p>

        <div class="bg-gray-50 border border-gray-200 rounded-md p-4 flex items-center justify-between mb-4">
            <span id="ipAddress" class="text-lg font-mono font-bold text-blue-600">{{ $serverIp }}</span>
            <button onclick="copyIp()" class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded transition">
                Salin IP
            </button>
        </div>

        <div id="alertMsg" class="hidden text-green-600 text-sm font-semibold mb-4">
            ✓ IP berhasil disalin!
        </div>

        <div class="mt-6 border-t pt-4">
            <a href="https://member.digiflazz.com/pengaturan/ip-whitelist" target="_blank" class="inline-block bg-orange-500 hover:bg-orange-600 text-white font-medium text-sm px-4 py-2 rounded">
                Buka Whitelist Digiflazz ↗
            </a>
        </div>
    </div>

    <script>
        function copyIp() {
            const ipText = document.getElementById('ipAddress').innerText;
            navigator.clipboard.writeText(ipText).then(() => {
                const alert = document.getElementById('alertMsg');
                alert.classList.remove('hidden');
                setTimeout(() => alert.classList.add('hidden'), 3000);
            });
        }
    </script>
</body>
</html>
