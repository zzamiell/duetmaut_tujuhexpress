@section('scripts')
<script type="text/javascript">
$(document).ready(function() {
    // alert("hello");

    // override selected or order status
    var params = new window.URLSearchParams(window.location.search);
    var order_status=Number(params.get('order_status')) === 0 ? "all" : params.get('order_status');
    $('#orderStatusSelection option:contains(' + order_status + ')').prop({selected: true});

});

function onChangeTotalData() {
    var params = new window.URLSearchParams(window.location.search);
    var page = Number(params.get('page')) === 0 ? 1 : Number(params.get('page'));
    var max_page=$('#max_page').val();
    var tanggal_awal=$('#tanggal_awal').val();
	var tanggal_akhir=$('#tanggal_akhir').val();
    var order_status=Number(params.get('order_status')) === 0 ? "all" : params.get('order_status');
    var base_url = `${window.location.protocol}//${window.location.host}`;

    console.log("......");
    console.log("page : "+page);
    console.log("max page : "+max_page);
    console.log("base url : "+base_url);
    console.log("tanggal awal : "+tanggal_awal);
    console.log("tanggal akhir : "+tanggal_akhir);
    var newUrl = `${base_url}/orders/index?max_page=${max_page}&page=${page}`;
    

    if(tanggal_awal != '') {
        newUrl += `&tanggal_awal=${tanggal_awal}`
    } 

    if(tanggal_akhir != '') {
        newUrl += `&tanggal_akhir=${tanggal_akhir}`
    } 

    if(order_status != "all") {
        newUrl += `&order_status=${order_status}`
    }

    console.log("new url : "+newUrl);

    window.location.replace(newUrl);
}

</script>
@stop