@empty($barang)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i>Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/barang') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Data Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <h5><i class="icon fas fa-info"></i> Data Barang </h5>
                    Berikut adalah detail dari data barang
                </div>
                <table class="table table-sm table-bordered table-stripped">
                    <tr>
                        <th class="text-right col-3">Kategori Barang : </th>
                        <td class="col-9">{{ $barang->kategori->kategori_nama }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Kode Barang : </th>
                        <td class="col-9">{{ $barang->barang_kode }} </td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Nama Barang : </th>
                        <td class="col-9">{{ $barang->barang_nama }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Harga Beli : </th>
                        <td class="col-9">{{ $barang->harga_beli }}</td>
                    </tr>
                    <tr>
                        <th class="text-right col-3">Harga Jual : </th>
                        <td class="col-9">{{ $barang->harga_jual }}</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Kembali</button>
            </div>
        </div>
    </div>
@endempty