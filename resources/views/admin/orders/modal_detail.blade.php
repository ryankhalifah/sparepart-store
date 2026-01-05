{{-- Modal untuk Order ID: {{ $order->id }} --}}
<div class="modal fade" id="detailModal-{{ $order->id }}" tabindex="-1" aria-labelledby="detailModalLabel-{{ $order->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content elegant-modal">
            <div class="modal-header bg-gradient-purple text-white">
                <h5 class="modal-title fw-bold" id="detailModalLabel-{{ $order->id }}">
                    <i class="fas fa-receipt me-2"></i> Detail Pesanan #{{ $order->id }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="order-info mb-4 p-3 rounded shadow-sm">
                    <p><strong>Pelanggan:</strong> {{ $order->user->name ?? 'User Dihapus' }}</p>
                    <p><strong>Email:</strong> {{ $order->user->email ?? '-' }}</p>
                    <p><strong>Tanggal:</strong> {{ $order->created_at->format('d M Y, H:i') }}</p>
                    <p><strong>Status:</strong>
                        <span class="badge 
                            @if($order->status == 'selesai') bg-success 
                            @elseif($order->status == 'proses') bg-warning 
                            @else bg-secondary @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </p>
                </div>

                <h5 class="fw-bold text-purple mb-3"><i class="fas fa-box-open me-2"></i> Item Pesanan:</h5>
                <div class="table-responsive shadow-sm rounded">
                    <table class="table table-bordered align-middle">
                        <thead class="table-purple text-white">
                            <tr>
                                <th>Nama Spare Part</th>
                                <th>Jumlah</th>
                                <th>Harga Satuan</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $item)
                            <tr>
                                <td>{{ $item->sparepart->nama ?? 'Produk Dihapus' }}</td>
                                <td>{{ $item->jumlah }}</td>
                                <td>Rp {{ number_format($item->subtotal / $item->jumlah, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="fw-bold bg-light">
                                <td colspan="3" class="text-end">Total Harga Pesanan:</td>
                                <td class="text-purple">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="modal-footer border-top">
                <button type="button" class="btn btn-purple" data-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Tambahan style untuk tema ungu elegan --}}
<style>
    .bg-gradient-purple {
        background: linear-gradient(135deg, #6a1b9a, #8e24aa, #9c27b0);
    }

    .text-purple {
        color: #6a1b9a !important;
    }

    .btn-purple {
        background-color: #8e24aa;
        border: none;
        color: #fff;
        transition: all 0.3s ease;
    }

    .btn-purple:hover {
        background-color: #6a1b9a;
        transform: scale(1.03);
    }

    .table-purple {
        background-color: #8e24aa;
    }

    .elegant-modal {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 25px rgba(138, 43, 226, 0.25);
        background: #fff;
    }

    .order-info {
        background-color: #f8f3fb;
        border-left: 5px solid #8e24aa;
    }
</style>
