<div class="table-responsive">
    <table class="table table-bordered table-hover align-middle" width="100%" cellspacing="0">
        <thead class="table-light">
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">Gambar</th>
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
                        $imgRaw = ($type == 'tour') ? $item->cover_image_url : $item->image;
                        
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
                
                {{-- KOLOM NAMA --}}
                <td class="fw-bold">{{ $item->name }}</td>

                {{-- KOLOM 2 (Biasanya Tipe atau Agen) --}}
                @if($type == 'trans_local' || $type == 'trans_inter')
                    <td>
                        <span class="badge {{ ($item->type == 'mobil' || $item->type == 'travel') ? 'bg-primary' : 'bg-success' }}">
                            {{ ucfirst($item->type) }}
                        </span>
                    </td>
                @else
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="bg-light rounded-circle d-flex justify-content-center align-items-center me-2" style="width: 30px; height: 30px;">
                                <i class="fas fa-user text-secondary small"></i>
                            </div>
                            <span>{{ $item->agent->name ?? 'Agen Terhapus' }}</span>
                        </div>
                    </td>
                @endif

                {{-- KOLOM 3 & 4 (Dinamis sesuai Tipe) --}}
                @if($type == 'tour')
                    <td>{{ $item->duration ?? '-' }}</td>
                    <td class="text-success fw-bold">Rp {{ number_format($item->price_per_person, 0, ',', '.') }}</td>
                
                @elseif($type == 'stay')
                    <td><i class="fas fa-map-marker-alt text-danger me-1"></i> {{ $item->location }}</td>
                    <td class="text-success fw-bold">{{ $item->price_start }}</td>
                
                @elseif($type == 'oleh')
                    <td><i class="fas fa-map-marker-alt text-danger me-1"></i> {{ $item->location }}</td>
                    <td>{{ $item->price_range }}</td>

                @elseif($type == 'trans_local')
                    <td>{{ $item->agent->name ?? '-' }}</td>
                    <td>{{ $item->price_range }}</td>

                @elseif($type == 'trans_inter')
                    <td>{{ $item->agent->name ?? '-' }}</td>
                    <td><small>{{ $item->location }}</small></td>
                @endif

                {{-- AKSI --}}
                <td class="text-center" style="min-width: 120px;">
                    
                    <div class="d-flex justify-content-center gap-2">
                        
                        {{-- TOMBOL EDIT (BARU) --}}
                        @php
                            // Tentukan route edit berdasarkan type
                            $routeEditMap = [
                                'tour' => 'admin.listings.tours.edit',
                                'stay' => 'admin.listings.penginapan.edit',
                                'oleh' => 'admin.listings.oleh-oleh.edit',
                                'trans_local' => 'admin.listings.transport-daerah.edit',
                                'trans_inter' => 'admin.listings.transport-luar.edit',
                            ];
                            $routeEditName = $routeEditMap[$type] ?? '#';
                        @endphp

                        <a href="{{ route($routeEditName, $item->id) }}" class="btn btn-warning btn-sm shadow-sm text-white" title="Edit">
                            <i class="fas fa-pen"></i>
                        </a>

                        {{-- TOMBOL HAPUS (LAMA) --}}
                        <form action="{{ route($routeDelete, $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
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
                <td colspan="{{ count($cols) + 3 }}" class="text-center py-5 text-muted">
                    <img src="{{ asset('images/logo.png') }}" alt="Empty" style="width: 60px; opacity: 0.5; filter: grayscale(100%);" class="mb-2 d-block mx-auto">
                    Belum ada data listing untuk kategori ini.
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