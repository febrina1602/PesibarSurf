<div class="table-responsive">
    <table class="table table-bordered table-hover align-middle" width="100%" cellspacing="0">
        <thead class="table-light">
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">Gambar</th>
                {{-- Loop header kolom sesuai parameter yang dikirim --}}
                @foreach($cols as $col)
                    <th>{{ $col }}</th>
                @endforeach
                <th style="width: 10%;" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $item)
            <tr>
                <td>{{ $data->firstItem() + $index }}</td>
                <td>
                    @php 
                        // Logika gambar hanya untuk Tour (cover_image)
                        $imgRaw = $item->cover_image_url; 
                        
                        if (Str::startsWith($imgRaw, 'http')) {
                            $imgSrc = $imgRaw;
                        } elseif (Str::contains($imgRaw, 'storage')) {
                            $imgSrc = asset($imgRaw);
                        } else {
                            $imgSrc = asset('storage/' . $imgRaw);
                        }
                    @endphp
                    
                    <img src="{{ $imgSrc }}" 
                         alt="Img" 
                         width="80" height="60"
                         style="object-fit: cover; border-radius: 6px; background-color: #f0f0f0;"
                         onerror="this.onerror=null;this.src='{{ asset('images/logo.png') }}';">
                </td>
                
                {{-- KOLOM 1: NAMA --}}
                <td class="fw-bold">{{ $item->name }}</td>

                {{-- KOLOM 2: AGEN --}}
                <td>
                    <div class="d-flex align-items-center">
                        <div class="bg-light rounded-circle d-flex justify-content-center align-items-center me-2" style="width: 30px; height: 30px;">
                            <i class="fas fa-user text-secondary small"></i>
                        </div>
                        <span>{{ $item->agent->name ?? 'Agen Terhapus' }}</span>
                    </div>
                </td>

                {{-- KOLOM 3: DURASI --}}
                <td>{{ $item->duration ?? '-' }}</td>

                {{-- KOLOM 4: HARGA --}}
                <td class="text-success fw-bold">Rp {{ number_format($item->price_per_person, 0, ',', '.') }}</td>
                
                {{-- KOLOM AKSI --}}
                <td class="text-center" style="min-width: 120px;">
                    <div class="d-flex justify-content-center gap-2">
                        
                        {{-- Tombol Edit --}}
                        <a href="{{ route('admin.listings.tours.edit', $item->id) }}" class="btn btn-warning btn-sm shadow-sm text-white" title="Edit">
                            <i class="fas fa-pen"></i>
                        </a>

                        {{-- Tombol Hapus --}}
                        <form action="{{ route($routeDelete, $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus paket wisata ini?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm shadow-sm" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>

                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center py-5 text-muted">
                    <img src="{{ asset('images/logo.png') }}" alt="Empty" style="width: 60px; opacity: 0.5; filter: grayscale(100%);" class="mb-2 d-block mx-auto">
                    Belum ada data paket wisata.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- PAGINATION --}}
<div class="d-flex justify-content-end mt-3">
    {{ $data->appends(request()->query())->links() }}
</div>