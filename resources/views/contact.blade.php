@extends('layouts.app', ['activePage' => 'contact', 'titlePage' => __('Contacto')])

@section('content')
    <div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Contacto</h4>
                        {{--<p class="card-category"> Here you can manage users</p>--}}
                    </div>
                    <div class="card-body">
                        <div class="row">
                        <div class="col-md-4">
                            <div class="fancy-title">
                                <h3>Solair</h3>
                            </div>
                            <p>. 9 Este No. 15-Planta Alta, Civac, 62578 Jiutepec, Mor.</p>
                        </div><br>
                            <div class="col-md-4">
                        <div class="fancy-title">
                            <h3>TunaliTec Cuernavaca</h3>
                        </div>
                            <p>Calle 40 - Sur MZ 8, LT 8-B, Civac, 62500 Jiutepec, Mor.</p>
                        </div>
                            <br>
                            <div class="col-md-4">
                                <div class="fancy-title">
                                    <h3>TunaliTec Guadalajara</h3>
                                </div>
                                <p>Parque Industrial Cañas, Avenida Cañas 3250 Bodega 14, Entre Lazaro Cardenas y Av. Cañas, La Nogalera, 44470 Guadalajara, Jal.</p>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-md-6"><br>
                            <h4>TunaliTec México</h4><br>
                            <div itemscope itemtype="http://schema.org/LocalBussiness">
                                <a href="tel:018000088625" itemprop="telephone" title="Teléfono Cuernavaca"><p><span class="material-icons">phone</span>&nbsp;&nbsp;&nbsp;Cuernavaca: (777) 176 1415 </p></a>


                                <a href="tel:3336573660" itemprop="telephone" title="Teléfono Guadalajara"><p><span class="material-icons">phone</span>&nbsp;&nbsp;&nbsp;Guadalajara: (33) 1580 0601</p></a>

                                <a href="tel:7773620636" itemprop="telephone" title="Teléfono Solair"><p><span class="material-icons">phone</span>&nbsp;&nbsp;&nbsp;Solair: (777) 516 6430
                                    </p></a>

                                <a href="mailto:informes@tunalitec.com" itemprop="email" title="Email"><p><span class="material-icons">email</span>&nbsp;&nbsp;&nbsp;Correo: informes@tunalitec.com</p></a>
                                <a href="http://www.tunalitec.com"><p><span class="material-icons">public</span>&nbsp;&nbsp;&nbsp;Sitio Web: www.tunalitec.com</p></a>
                                <a href="http://www.solairmexico.com"><p><span class="material-icons">public</span>&nbsp;&nbsp;&nbsp;Sitio Web: www.solairmexico.com</p></a>

                            </div>

                        </div>

                        <div class="col-md-6"><br>
                            <h4>Redes sociales</h4><br>
                            <div itemscope itemtype="http://schema.org/LocalBussiness">
                                <a href="https://www.facebook.com/tunali.tec" title="facebook" aria-label="facebook"><p><span class="fa fa-facebook"></span>&nbsp;&nbsp;&nbsp;facebook</p></a>

                                <a href="https://www.linkedin.com/company/tunalitec/"  title="linkedin" aria-label="linkedin"><p><span class="fa fa-linkedin"></span>&nbsp;&nbsp;&nbsp;linkedin</p></a>

                                <a href="tel:7773495107"  title="whatsapp" aria-label="whatsapp"><p><span class="fa fa-whatsapp"></span>&nbsp;&nbsp;&nbsp;WhatsApp</p></a>

                                <a href="https://www.youtube.com/channel/UCxP9qkwZQJ3yTuZELkvacLw"  title="youtube" aria-label="youtube"><p><span class="fa fa-youtube"></span>&nbsp;&nbsp;&nbsp;YouTube</p></a>

                            </div>

                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
