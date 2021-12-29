function convertAngkaToRupiah(angka)
{
    var rupiah = '';		
    var angkarev = angka.toString().split('').reverse().join('');
    for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
    return 'Rp '+rupiah.split('',rupiah.length-1).reverse().join('');
}

function convertRupiahToAngka(rupiah)
{
    return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
}

let toastrOptions = {
    "showMethod": "slideDown",
    "hideMethod": "slideUp",
    "closeMethod": "slideUp",
    "positionClass": "toast-top-center"
    // "preventDuplicates": "true"
};

function cekApakahTokoTutup() 
{
    moment().format();
    // moment().tz("America/Los_Angeles").format();

    let jamBuka = moment().startOf('day').hours('8'); // jam buka jam 8 pagi

    let jamTutup =  moment().startOf('day').hours('17'); // jam tutup jam 5 sore

    let tercakup = moment().isBetween(jamBuka, jamTutup); // true

    if(!tercakup)
    {
        return true;
    }
    else
    {
        return false;
    }
}

function tampilkanCustomModal(isi, durasi)
{
    $('#isi-info').text(isi);

    $('#customModal').modal('toggle')

    setInterval($('#customModal').modal('toggle'), durasi);
    
}   