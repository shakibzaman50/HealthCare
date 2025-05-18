<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="{{ asset('/') }}assets/plugins/global/plugins.bundle.js"></script>
<script src="{{ asset('/') }}assets/js/scripts.bundle.js"></script>
<script src="{{ asset('/') }}assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
<script src="{{ asset('/') }}assets/plugins/custom/datatables/datatables.bundle.js"></script>
<script>
    function pushDocument(path){
        document.querySelector('#downloadFile').href= '{{ asset('/') }}' + path;
        if ( path.endsWith('.pdf')){
            document.querySelector('#pdfView').src= '{{ asset('/') }}' + path;
            document.querySelector('#pdfDiv').style.display = "";
            document.querySelector('#imageDiv').style.display = "none";
            document.querySelector('#downloadFile').download= 'document'+ Math.floor(Math.random()*999999999999) +'.pdf';
        }
        else {
            document.querySelector('#imageView').src = '{{ asset('/') }}' + path;
            document.querySelector('#imageDiv').style.display = "";
            document.querySelector('#pdfDiv').style.display = "none";
            document.querySelector('#downloadFile').download= 'document'+ Math.floor(Math.random()*999999999999)+ '.jpg'
        }
    }

    function logout(){
        document.querySelector('#logout_form').submit()
    }
</script>
@if(Session::has('success'))
    <script>
        $(document).ready(function() {
            Swal.fire({
                icon: 'success',
                title: "Success",
                text: "{{ Session::get('success') }}",
                showConfirmButton: false,
                timer: 1000
            })
        });
    </script>
@endif
@if(Session::has('info'))
    <script>
        $(document).ready(function() {
            Swal.fire({
                icon: 'info',
                title: "Hey..",
                text: "{{ Session::get('info') }}",
            })
        });
    </script>
@endif
@if(Session::has('warning'))
    <script>
        $(document).ready(function() {
            Swal.fire({
                icon: 'warning',
                title: "Warning",
                text: "{{ Session::get('warning') }}",
                // showConfirmButton: false,
                // timer: 1500,
            })
        });
    </script>
@endif
@if(Session::has('error'))
    <script>
        $(document).ready(function() {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ Session::get('error') }}!",
                // footer: '<a href="">Why do I have this issue?</a>'
            })
        });
    </script>
@endif
