<h2>Daftar Buku</h2>

@if(session('error'))
    <p style="color:red">{{ session('error') }}</p>
@endif

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

@foreach($buku as $b)
    <p>
        {{ $b->judul }} (Stok: {{ $b->stok }})

        <form action="/pinjam/{{ $b->id }}" method="POST">
            @csrf
            <button type="submit">Pinjam</button>
        </form>
    </p>
@endforeach
    
<hr>

<h2>Buku Saya</h2>

@foreach($pinjam as $p)
    <p>
        {{ $p->buku->judul }} - {{ $p->status }}

        @if($p->status == 'dipinjam')
        <form action="/kembali/{{ $p->id }}" method="POST">
            @csrf
            <form action="/pinjam/{{ $b->id }}" method="POST">
    
            <button type="submit">Pinjam</button>
        </form>
            <button type="submit">Kembalikan</button>
        </form>
        @endif
    </p>
@endforeach