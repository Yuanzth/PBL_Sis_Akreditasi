@if(!$penjualan)
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Kesalahan</h5>
            <button type="button" class="close" data-dismiss="modal">
                <span>X</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger">Data tidak ditemukan.</div>
        </div>
    </div>
</div>
@else
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header bg-primary text-white">
            <h5 class="modal-title"></h5>
            <button type="button" class="close text-white" data-dismiss="modal">
                <span>X</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="receipt-container">
                <div class="receipt-header text-center mb-4">
                    <img src="{{ asset('adminlte/dist/img/AditsStoreLogo.png') }}" alt="Adit's Store Logo" class="store-logo mb-3">
                    <h3 class="mb-1">ADIT'S STORE</h3>
                    <p class="mb-0">ONE-STOP NEEDS SOLUTION</p>
                    <p class="mb-0">Jl. Teluk Ratai IV No. 15</p>
                    <p class="mb-0">Telp: (021) 210738742</p>
                </div>
                
                <div class="receipt-body">
                    <div class="row mb-3">
                        <div class="col-6">
                            <strong>Kode Transaksi:</strong> {{ $penjualan->penjualan_kode }}
                        </div>
                        <div class="col-6 text-right">
                            <strong>Tanggal:</strong> {{ $penjualan->penjualan_tanggal->translatedFormat('d M Y H:i') }}
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-12">
                            <strong>Kasir:</strong> {{ $penjualan->user->nama ?? 'System' }}
                        </div>
                        <div class="col-12">
                            <strong>Pembeli:</strong> {{ $penjualan->pembeli }}
                        </div>
                    </div>

                    <table class="table receipt-table">
                        <thead class="bg-light">
                            <tr>
                                <th>Barang</th>
                                <th class="text-right">Harga</th>
                                <th class="text-center">Qty</th>
                                <th class="text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($penjualan->details as $detail)
                            <tr>
                                <td>{{ $detail->barang->barang_nama ?? '-' }}</td>
                                <td class="text-right">@currency($detail->harga)</td>
                                <td class="text-center">{{ $detail->jumlah }}</td>
                                <td class="text-right">@currency($detail->harga * $detail->jumlah)</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-light">
                            <tr>
                                <th colspan="3" class="text-right">TOTAL</th>
                                <th class="text-right">@currency($penjualan->details->sum(fn($d) => $d->harga * $d->jumlah))</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="receipt-footer text-center mt-4 d-print-block">
                    <p class="mb-1">Terima kasih telah berbelanja</p>
                    <p class="mb-0">Barang yang sudah dibeli tidak dapat dikembalikan</p>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="button" class="btn btn-success" onclick="printReceipt()">
                <i class="fas fa-print"></i> Cetak Struk
            </button>
        </div>
    </div>
</div>
@endif

<style>
    .receipt-container {
        max-width: 500px;
        margin: 0 auto;
        padding: 20px;
        border: 2px solid #000;
    }

    .receipt-header h3 {
        font-size: 24px;
        font-weight: bold;
    }

    .receipt-table {
        width: 100%;
        margin: 15px 0;
    }

    .receipt-table th,
    .receipt-table td {
        padding: 8px;
        border-top: none;
        border-bottom: 1px solid #dee2e6;
    }

    .store-logo {
        max-width: 200px;
        height: auto;
        display: block;
        margin: 0 auto 10px;
    }

    @media print {
        /* Sembunyikan modal asli saat cetak */
        .modal {
            display: none !important;
        }
        
        /* Tampilkan konten struk saja */
        .receipt-container {
            visibility: visible !important;
            position: relative !important;
            max-width: 100% !important;
            border: none !important;
            padding: 0 !important;
            margin: 0 auto !important;
            page-break-inside: avoid;
        }
        .store-logo {
            max-width: 250px;
        }
        
        /* Reset ukuran kertas */
        @page {
            size: A4 portrait;
            margin: 10mm;
        }
        
    }
</style>

<script>
    function printReceipt() {
        // Clone konten modal
        const originalContent = document.querySelector('.modal-content').cloneNode(true);
        
        // Hapus elemen yang tidak ingin dicetak
        originalContent.querySelector('.modal-header').remove();
        originalContent.querySelector('.modal-footer').remove();
        
        // Ambil semua stylesheet dari dokumen utama
        const stylesheets = Array.from(document.querySelectorAll('link[rel="stylesheet"], style'))
            .map(el => el.outerHTML)
            .join('\n');

        const printWindow = window.open('', '_blank');
        
        printWindow.document.write(`
            <html>
                <head>
                    <title>Struk Penjualan</title>
                    ${stylesheets}
                    <style>
                        /* Reset style untuk cetakan */
                        body { 
                            margin: 0 !important; 
                            padding: 20px !important;
                            -webkit-print-color-adjust: exact;
                        }
                        
                        /* Sembunyikan elemen tidak perlu */
                        .modal-header, .modal-footer {
                            display: none !important;
                        }
                        
                        /* Sesuaikan dengan tampilan modal */
                        .receipt-container {
                            max-width: 500px;
                            margin: 0 auto;
                            border: 2px solid #000;
                            padding: 20px;
                        }
                        
                        @media print {
                            .receipt-container {
                                border: none;
                                padding: 0;
                            }
                        }
                    </style>
                </head>
                <body>
                    ${originalContent.outerHTML}
                </body>
            </html>
        `);
        
        printWindow.document.close();
        
        setTimeout(() => {
            printWindow.print();
            printWindow.close();
        }, 500);
    }
</script>