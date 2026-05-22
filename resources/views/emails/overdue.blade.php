<div style="font-family:Inter,system-ui,Arial,sans-serif;color:#0f172a;">
    <h2>Pemberitahuan Peminjaman Terlambat</h2>
    <p>Hai {{ $loan->member->name }},</p>
    <p>Anda memiliki peminjaman buku yang terlambat dikembalikan:</p>
    <ul>
        <li><strong>Buku:</strong> {{ $loan->book->title }}</li>
        <li><strong>Dipinjam pada:</strong> {{ $loan->borrowed_at->format('Y-m-d') }}</li>
        <li><strong>Jatuh tempo:</strong> {{ $loan->due_at->format('Y-m-d') }}</li>
    </ul>
    <p>Mohon segera kembalikan buku tersebut. Terima kasih.</p>
</div>
