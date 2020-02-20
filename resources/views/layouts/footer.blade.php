@if(request()->segment(1) !== 'coming_soon')
<footer>
    <div class="container footer-top">

        <div class="row">

            <div class="col-md-5 col-sm-5">
                <div class="footer-about">

                    {{--                        <img class="footer-about-logo" src="{{ asset('assets/images/footer_logo.png') }}" />--}}
                    <svg width="266" height="61" viewBox="0 0 1473 339" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M441.456 303.26H405.992V335.875H384V254H445.028V269.239H405.992V288.077H441.456V303.26Z" fill="white"/>
                        <path d="M587.965 254V307.59C587.965 313.663 586.524 318.93 583.642 323.392C580.759 327.815 576.624 331.189 571.236 333.514C565.847 335.838 559.477 337 552.125 337C541.014 337 532.263 334.413 525.872 329.24C519.481 324.066 516.223 316.981 516.098 307.984V254H538.216V308.377C538.466 317.337 543.103 321.817 552.125 321.817C556.678 321.817 560.124 320.692 562.464 318.443C564.803 316.194 565.972 312.539 565.972 307.478V254H587.965Z" fill="white"/>
                        <path d="M740.175 335.875H718.308L685.977 284.928V335.875H663.985V254H685.977L718.246 304.947V254H740.175V335.875Z" fill="white"/>
                        <path d="M816.321 335.875V254H845.707C853.769 254 861.016 255.65 867.449 258.949C873.881 262.21 878.894 266.84 882.486 272.838C886.12 278.799 887.958 285.491 888 292.913V296.681C888 304.179 886.225 310.908 882.674 316.869C879.165 322.792 874.195 327.44 867.762 330.814C861.371 334.151 854.228 335.838 846.333 335.875H816.321ZM838.313 269.239V320.692H845.957C852.265 320.692 857.11 318.687 860.494 314.675C863.877 310.627 865.569 304.629 865.569 296.681V293.138C865.569 285.228 863.877 279.267 860.494 275.256C857.11 271.245 852.181 269.239 845.707 269.239H838.313Z" fill="white"/>
                        <path d="M643.52 57H712.047V1H521.207C558.573 4.2 567.822 39.6654 567.776 56.998L588.479 57V215.023H643.52V57Z" fill="white"/>
                        <path d="M495.435 156.796C495.435 149.452 492.725 143.73 487.303 139.629C481.98 135.527 472.566 131.283 459.062 126.896C445.557 122.509 434.517 118.264 425.941 114.163C398.045 100.906 384.097 82.6893 384.097 59.513C384.097 47.9725 387.547 37.815 394.447 29.0405C401.446 20.1705 411.303 13.3035 424.019 8.43931C436.735 3.47977 451.028 1 466.898 1C482.374 1 496.224 3.67052 508.447 9.01156C520.769 14.3526 530.33 21.9827 537.132 31.9017C542.342 39.4275 545.557 47.793 546.776 56.998H494.462C493.196 52.5521 490.859 48.8601 487.451 45.922C482.128 41.2486 474.883 38.9118 465.716 38.9118C456.45 38.9118 449.106 40.9147 443.685 44.9205C438.362 48.8309 435.7 53.8381 435.7 59.9422C435.7 65.2832 438.657 70.1474 444.572 74.5347C450.486 78.8266 460.886 83.3092 475.77 87.9826C490.655 92.5607 502.878 97.5202 512.439 102.861C535.702 115.832 547.334 133.715 547.334 156.51C547.334 174.727 540.237 189.033 526.042 199.429C511.848 209.825 492.38 215.023 467.638 215.023C450.19 215.023 434.369 212.019 420.175 206.01C406.079 199.906 395.433 191.608 388.237 181.117C387.734 180.476 387.287 179.77 386.89 179.019C384.282 174.083 383.848 167.197 384 164H434.107C435.325 166.04 436.793 167.836 438.51 169.386C444.522 174.631 454.232 177.254 467.638 177.254C476.214 177.254 482.966 175.49 487.895 171.961C492.922 168.337 495.435 163.282 495.435 156.796Z" fill="white"/>
                        <path d="M1277 139.172V0H1223.14V138.882C1223.14 151.931 1220.28 161.355 1214.55 167.154C1208.82 172.954 1200.38 175.854 1189.23 175.854C1167.13 175.854 1155.78 164.303 1155.17 141.202V77.5H1101V140.187C1101.31 163.385 1109.29 181.653 1124.94 194.992C1140.59 208.331 1162.02 215 1189.23 215C1207.23 215 1222.83 212.004 1236.03 206.011C1249.23 200.018 1259.35 191.319 1266.41 179.913C1273.47 168.411 1277 154.831 1277 139.172Z" fill="white"/>
                        <path d="M1353.94 215.023V163.998H1391.33C1402.17 163.924 1412.5 161.735 1421.94 157.824C1451.48 145.582 1472.26 116.468 1472.26 82.5C1472.26 37.4888 1435.77 1 1390.76 1H1297.73V56.998H1297.95H1348.45H1394.95C1408.76 56.998 1419.95 68.1909 1419.95 81.998V82.998C1419.95 96.8052 1408.76 107.998 1394.95 107.998H1348.45H1297.95L1297.73 108.012V215.023H1353.94Z" fill="white"/>
                        <path d="M732.232 164H793.232L810.413 215.023H863.995L787.531 1H735.898L773.232 108H700.232L664.732 215.023H718.03L732.232 164Z" fill="white"/>
                        <path d="M1080.71 56.998H1155V1H975C990.5 4.5 1010.5 28 1013 56.998H1025.37V215.023H1080.71V56.998Z" fill="white"/>
                        <path d="M867.056 164.003H896.621L934.843 215.023L997.233 215H1000.73L948.422 143.858C975.425 132.667 994.42 106.054 994.42 75.0044C994.42 33.8592 961.065 1 919.92 1L903.295 1.00034H808.732L828.732 56.9984H864.452H910.952C924.759 56.9984 935.952 68.1913 935.952 81.9984V82.9984C935.952 96.8055 924.759 107.998 910.952 107.998H864.452H847.232L867.056 164.003Z" fill="white"/>
                        <path d="M148.244 207.355C151.209 206.762 160.697 206.762 162.476 208.541C164.848 210.32 161.29 210.32 161.29 210.32C160.697 210.32 160.697 210.913 160.697 211.506C161.29 210.913 161.29 210.913 161.29 210.913C161.29 210.913 164.848 216.843 182.637 197.275C193.904 184.229 206.356 185.415 212.879 187.194C203.985 181.264 176.707 187.194 157.732 183.043C155.953 191.345 152.395 199.646 148.244 207.355Z" fill="white"/>
                        <path d="M0 1V339H338V1H0ZM270.993 106.551C270.993 106.551 271.586 105.365 272.179 104.772C268.621 106.551 261.505 112.481 248.46 129.677C248.46 129.677 245.495 130.863 242.53 132.049C244.902 132.642 246.681 132.642 248.46 131.456C248.46 131.456 238.972 147.467 227.112 142.723C219.404 139.758 211.695 130.863 208.137 122.561C206.358 123.154 204.579 123.747 202.207 123.747C198.649 128.491 192.126 132.049 182.046 137.386C168.407 144.502 171.372 150.432 171.372 150.432C171.372 150.432 171.372 151.025 170.779 151.618H171.372C204.579 148.653 232.449 171.779 232.449 184.825C231.263 198.463 214.067 201.428 214.067 201.428C214.067 201.428 214.66 200.835 215.253 200.242C214.067 200.835 212.881 201.428 211.102 202.021C193.312 205.579 171.965 218.625 166.628 221.589C167.814 222.775 169 223.961 169.593 224.554C169.593 228.112 158.919 232.263 158.919 232.263C152.397 237.007 151.211 246.495 151.211 250.053C151.211 253.611 143.502 257.761 139.351 248.867C135.2 240.565 140.537 231.077 143.502 227.519C146.467 223.961 145.874 222.182 145.874 222.182C145.281 217.439 145.874 213.881 145.874 211.509C139.944 220.996 134.607 228.112 134.607 228.112C134.607 228.112 134.607 228.112 134.607 228.705C130.456 232.856 126.898 232.856 112.667 238.193C108.516 239.379 104.365 242.344 100.214 244.716C94.2842 250.053 89.5404 255.982 84.7965 260.726C84.2035 261.319 84.2035 261.319 83.6106 261.912C85.3895 262.505 86.5755 263.098 87.1684 263.691C88.3544 264.877 87.1684 269.028 84.2035 273.772C81.2386 278.516 85.3895 288.596 90.7263 288.596C96.0632 289.782 94.2842 295.119 94.2842 295.119C94.2842 295.119 89.5404 298.084 79.4597 295.119C69.379 292.154 72.3439 279.702 67.6 276.737C62.8562 273.772 57.5193 266.063 57.5193 260.133C57.5193 254.796 64.0421 257.168 66.4141 255.389C69.379 253.611 71.7509 253.611 71.7509 253.611C71.7509 257.761 72.9369 260.133 74.7158 260.726C73.5299 257.761 72.9369 254.204 72.9369 254.204C72.9369 254.204 79.4597 252.425 88.3544 237.007C96.6562 222.182 99.0281 218.032 109.109 213.881C114.446 212.102 117.411 207.358 119.783 203.207C120.375 200.835 120.375 197.87 120.968 195.498C122.154 186.604 124.526 179.488 126.898 174.744C126.898 174.151 126.898 173.558 126.305 172.965C121.561 151.025 134.607 144.502 138.758 142.723C138.758 142.13 138.758 142.13 138.758 142.13C138.758 142.13 138.758 142.13 138.758 142.723C139.351 142.723 139.944 142.13 139.944 142.13C140.537 140.351 141.13 138.572 141.13 138.572C163.07 108.33 169.593 91.1333 171.965 82.8316C166.035 81.6456 160.698 79.8667 155.954 77.4947C155.954 77.4947 155.954 78.0877 156.547 78.6807C156.547 78.6807 149.432 75.1228 141.13 76.9018C134.014 78.6807 118.597 85.7965 113.26 91.1333C107.923 97.0632 106.144 100.621 102.586 98.8421C99.6211 97.0632 90.1334 92.3193 94.2842 85.2035C94.2842 85.2035 99.0281 83.4246 104.365 83.4246C109.109 83.4246 123.933 66.2281 132.235 63.2632C135.793 59.7053 143.502 54.9614 156.547 60.2982C174.93 67.414 193.905 59.1123 204.579 76.9018C204.579 76.9018 209.323 80.4596 212.881 75.1228C216.439 69.786 207.544 63.2632 215.846 53.1825C224.147 43.1018 240.751 46.6596 244.902 53.1825C249.646 59.7053 241.344 86.9825 237.786 86.9825C234.228 86.9825 224.74 81.6456 224.74 81.6456C224.74 81.6456 219.404 86.3895 219.404 95.2842C219.404 97.0632 219.404 99.4351 218.811 101.807C220.59 104.772 222.961 111.295 225.926 116.632C226.519 117.818 227.705 119.596 228.298 120.782C234.228 119.004 247.867 113.667 254.983 105.958C264.47 96.4702 257.354 95.2842 262.691 90.5404C262.691 90.5404 263.284 90.5403 263.284 89.9474C263.284 89.9474 263.284 89.9474 263.877 89.9474C263.877 89.9474 263.877 89.9474 264.47 89.9474C265.063 89.9474 265.063 89.3544 265.656 89.3544H266.249C266.249 89.3544 266.249 89.3544 266.842 89.3544C268.028 89.3544 269.214 89.9474 269.807 90.5404C271.586 92.3193 272.772 95.8772 272.179 98.2491C275.144 104.179 273.958 105.958 270.993 106.551Z" fill="white"/>
                    </svg>
                    <div class="clearfix">
                        {!! nl2br(get_option('footer_about_us')) !!}
                    </div>
                    <div class="social-btn">
                        <a href="https://www.facebook.com/startupfund.tn" target="_blank"><i class="fa fa-2x fa-facebook"></i></a>
                        <a href="https://twitter.com/StartupFundTn" target="_blank"><i class="fa fa-2x fa-twitter"></i></a>
                        <a href="https://www.linkedin.com/company/startup-fundtn" target="_blank"><i class="fa  fa-2x fa-linkedin"></i></a>
                    </div>

                </div>
            </div>

            <div class="col-md-5 col-sm-4">
                <div class="footer-widget">
                    <h4 class="footer-widget-title">@lang('app.contact_info') </h4>
                    <ul class="contact-info">
                        {!! get_option('footer_address') !!}
                    </ul>
                </div>
            </div>

            <div class="col-md-2 col-sm-3">
                <div class="footer-widget">
                    <h4 class="footer-widget-title">@lang('app.campaigns') </h4>
                    <ul class="contact-info">
                        @if(!Auth::user())
                            <li><a href="{{url('login_startup')}}">@lang('app.login_as_startup')</a></li>
                        @endif
                        <li><a href="{{route('register_startup')}}">@lang('app.start_a_campaign')</a></li>
                        <li><a href="{{route('browse_categories')}}">@lang('app.discover_campaign')</a></li>
                        <li><a href="/p/qui-sommes-nous">@lang('app.who_are_we')</a></li>
                    </ul>
                </div>
            </div>


        </div><!-- #row -->
    </div>


    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-5">
                    <p class="footer-copyright pull-left">Copyright © {{ now()->year }} {{ config('app.name') }}. All
                        Rights Reserved </p>
                </div>
                <div class="col-md-6 col-sm-7" style="overflow: hidden">
                    <ul class="contact-info  pull-right text-right">
                        <span><a href="{{route('home')}}">@lang('app.home')</a></span>
                        <span class="pipe">|</span>
                        <?php
                        $show_in_footer_menu = config('show_in_footer_menu');
                        ?>
                        @if($show_in_footer_menu->count() > 0)
                            @foreach($show_in_footer_menu as $page)
                                <span><a href="{{ route('single_page', $page->slug) }}"
                                       target="_blank">{{ $page->title }} </a></span>
                                <span class="pipe">|</span>
                            @endforeach
                        @endif
                        <span><a href="{{route('contact_us')}}"> @lang('app.contact_us')</a></span>

                    </ul>
                    {{--                    Acceuil |  Qui sommes nous | Condition d’utilisation | Contact--}}
                </div>
            </div>
        </div>
    </div>

</footer>
@endif
<!-- Scripts -->
<script src="{{ asset('assets/js/jquery-1.11.2.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
{{--<script src="{{ asset('assets/js/masonry.pkgd.min.js') }}"></script>--}}
<script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
@if(request()->segment(1) === 'register_startup')
    <script src="{{ asset('assets/js/rangeslider.js') }}"></script>
@endif
<!-- Conditional page load script -->

@if(request()->segment(1) === 'dashboard')
    <script src="{{ asset('assets/plugins/metisMenu/dist/metisMenu.min.js') }}"></script>
    <script>
        $(function (){
            $('#side-menu').metisMenu();
        });
    </script>
    <script src="https:////cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            $('table.for-datatable').DataTable(
                {
                "order": [[ 1, "asc" ]],
                "language": {
                    "sEmptyTable":     "Aucune donnée disponible dans le tableau",
                    "sInfo":           "Affichage de l'élément _START_ à _END_ sur _TOTAL_ éléments",
                    "sInfoEmpty":      "Affichage de l'élément 0 à 0 sur 0 élément",
                    "sInfoFiltered":   "(filtré à partir de _MAX_ éléments au total)",
                    "sInfoPostFix":    "",
                    "sInfoThousands":  ",",
                    "sLengthMenu":     "Afficher _MENU_ éléments",
                    "sLoadingRecords": "Chargement...",
                    "sProcessing":     "Traitement...",
                    "sSearch":         "Rechercher :",
                    "sZeroRecords":    "Aucun élément correspondant trouvé",
                    "oPaginate": {
                        "sFirst":    "Premier",
                        "sLast":     "Dernier",
                        "sNext":     "Suivant",
                        "sPrevious": "Précédent"
                    },
                    "oAria": {
                        "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
                        "sSortDescending": ": activer pour trier la colonne par ordre décroissant"
                    },
                    "select": {
                        "rows": {
                            "_": "%d lignes sélectionnées",
                            "0": "Aucune ligne sélectionnée",
                            "1": "1 ligne sélectionnée"
                        }
                    }
                },
                pageLength : 5,
                lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Todos']]
            }
            );
            $('.dataTables_filter input').addClass('form-control input-sm');
            $('#amount').on('input', function () {
                var amountError = false;
                if($(this).val() < 100){
                    $(".subscription-amount-error").html("Le montant doit etre supérieur ou égale à 100 DT")
                    amountError = true;
                }
                if (!Number.isInteger($(this).val() / 100)) {
                    $(".subscription-amount-error").html("Votre montant doit être multiple de 100 DT")
                    amountError = true;
                }
                if(amountError){
                    $("#paymentSpeciesBtn").attr('disabled','disabled')
                    $("#smtPaymentBtn").attr('disabled','disabled')
                    $("#bankTransferBtn00").attr('disabled','disabled')
                }else{
                    $(".subscription-amount-error").html("")
                    $("#paymentSpeciesBtn").removeAttr('disabled')
                    $("#smtPaymentBtn").removeAttr('disabled')
                    $("#bankTransferBtn00").removeAttr('disabled')
                }
                $('.amount').val($(this).val())
            })
            $('#paymentSpeciesBtn').click(function (){
                $('.panel-background').css('display', 'block');
                $('.mm-modal-dialog').css('display', 'flex');
            });

            $('.mm-modal-dialog .close').click(function (){
                $('.panel-background').css('display', 'none');
                $('.mm-modal-dialog').css('display', 'none');
            });

            $('.panel-background').click(function (){
                $('.panel-background').css('display', 'none');
                $('.mm-modal-dialog').css('display', 'none');
            });
        });
    </script>
@endif
<script src="{{ asset('assets/js/main.js') }}" data-turbolinks-eval="false" data-turbolinks-track="reload"></script>
<script>
    var toastr_options = { closeButton: true };
</script>
<script>
    /* $('.box-campaign-lists').masonry({
         itemSelector : '.box-campaign-item'
     });*/
</script>
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/turbolinks/5.2.0/turbolinks.js"></script>--}}
<script>
    $(function (){

        $('input[type="file"]').change(function (e){
            $('#profile-step1').attr("action", "ajax-upload-file");
            ;
            $('#profile-step1').submit();
        });

    });
</script>

@yield('menu-js')
@yield('page-js')


@if(get_option('additional_js') && get_option('additional_js') !== 'additional_js')
{!! get_option('additional_js') !!}
@endif

</body>
</html>
