function kelompokkanBilanganGenap(jumlahBilangan, jumlahKelompok) {
    if (jumlahBilangan <= 0 || jumlahKelompok <= 0) {
        return "JumlahBilangan dan JumlahKelompok harus lebih besar dari 0";
    }

    var bilanganGenap = [];
    for (var i = 2; i <= 2 * jumlahBilangan; i += 2) {
        bilanganGenap.push(i);
    }

    if (jumlahKelompok > jumlahBilangan) {
        return "JumlahKelompok tidak boleh lebih besar dari JumlahBilangan";
    }

    var hasilKelompok = [];
    var kelompokSize = Math.floor(jumlahBilangan / jumlahKelompok);
    var sisa = jumlahBilangan % jumlahKelompok;
    var startIndex = 0;

    for (var j = 0; j < jumlahKelompok; j++) {
        var endIndex = startIndex + kelompokSize + (sisa > 0 ? 1 : 0);
        hasilKelompok.push(bilanganGenap.slice(startIndex, endIndex));
        startIndex = endIndex;
        sisa--;
    }

    return hasilKelompok;
}

$(document).ready(function () {
    $("#btnHitung").click(function () {
        var jumlahBilangan = parseInt($("#jumlahBilangan").val());
        var jumlahKelompok = parseInt($("#jumlahKelompok").val());

        var hasil = kelompokkanBilanganGenap(jumlahBilangan, jumlahKelompok);

        $("#hasil").empty();

        for (var i = 0; i < hasil.length; i++) {
            $("#hasil").append("Kelompok " + (i + 1) + ": [" + hasil[i].join(", ") + "]<br>");
        }
    });
});
