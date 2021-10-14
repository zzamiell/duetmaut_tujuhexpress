@section('script')
<script type="text/javascript">

function onChangeTotalData() {
    var params = new window.URLSearchParams(window.location.search);
    var page = Number(params.get('page')) === 0 ? 1 : Number(params.get('page'));

    console.log("......");
    console.log(base_url);
}

</script>
@stop