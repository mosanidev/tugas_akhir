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

function showActiveSession()
{
    if("{{ session('success') }}" != "")
    {
        toastr.success("{{ session('success') }}", "Success", toastrOptions);
    } 
    else if ("{{ session('error') }}" != "")
    {
        toastr.error("{{ session('error') }}", "Error", toastrOptions);
    }
}

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

function showLoader(modalObject, object)
{
    $(modalObject).find($('#loader')).remove();

    modalObject.append(
        `<div class="m-5" id="loader">
            <div class="text-center">
                <div class="spinner-border" style="width: 5rem; height: 5rem; color:grey;" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>`
    );
    
    $('#loader').show();
    object.hide();
}

function closeLoader(modalObject, object) 
{
    $(modalObject).find($('#loader')).hide();
    object.show();
}