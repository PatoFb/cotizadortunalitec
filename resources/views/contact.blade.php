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
                            <p>Av 50 Metros manzana 6, Civac, 62578 Jiutepec, Mor.</p>
                        </div><br>
                            <div class="col-md-4">
                        <div class="fancy-title">
                            <h3>TunaliTec Cuernavaca</h3>
                        </div>
                            <p>Av 50 Metros manzana 6, Civac, 62500 Jiutepec, Mor.</p>
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
                                <a href="tel:7771761415" itemprop="telephone" title="Teléfono Cuernavaca"><p><span class="material-icons">phone</span>&nbsp;&nbsp;&nbsp;Cuernavaca: (777) 176 1415 </p></a>


                                <a href="tel:3315800601" itemprop="telephone" title="Teléfono Guadalajara"><p><span class="material-icons">phone</span>&nbsp;&nbsp;&nbsp;Guadalajara: (33) 1580 0601</p></a>

                                <a href="tel:8007865367" itemprop="telephone" title="Teléfono Solair"><p><span class="material-icons">phone</span>&nbsp;&nbsp;&nbsp;Solair: (800) 786 5367
                                    </p></a>

                                <a href="mailto:informes@tunalitec.com" itemprop="email" title="Email"><p><span class="material-icons">email</span>&nbsp;&nbsp;&nbsp;Correo: informes@tunalitec.com</p></a>
                                <a href="http://www.tunalitec.com"><p><span class="material-icons">public</span>&nbsp;&nbsp;&nbsp;Sitio Web: www.tunalitec.com</p></a>
                                <a href="http://www.solairmexico.com"><p><span class="material-icons">public</span>&nbsp;&nbsp;&nbsp;Sitio Web: www.solairmexico.com</p></a>

                            </div>

                        </div>

                        <div class="col-md-6"><br>
                            <h4>Redes sociales</h4><br>
                            <div itemscope itemtype="http://schema.org/LocalBussiness">
                                <a href="https://www.facebook.com/tunali.tec" title="facebook" aria-label="facebook" target="_blank"><p><span class="fa fa-facebook"></span>&nbsp;&nbsp;&nbsp;facebook</p></a>

                                <a href="https://www.linkedin.com/company/tunalitec/"  title="linkedin" aria-label="linkedin" target="_blank"><p><span class="fa fa-linkedin"></span>&nbsp;&nbsp;&nbsp;linkedin</p></a>

                                <a href="https://wa.me/527773495107" title="whatsapp" aria-label="whatsapp"><p><span class="fa fa-whatsapp" target="_blank"></span>&nbsp;&nbsp;&nbsp;WhatsApp</p></a>

                                <a href="https://www.youtube.com/channel/UCxP9qkwZQJ3yTuZELkvacLw"  title="youtube" aria-label="youtube" target="_blank"><p><span class="fa fa-youtube"></span>&nbsp;&nbsp;&nbsp;YouTube</p></a>

                            </div>

                        </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3774.25297806483!2d-99.17428632479847!3d18.920193382252556!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85ce7574fe25a61f%3A0x94cad193501586fa!2sToldos%20Solair%20M%C3%A9xico!5e0!3m2!1ses-419!2smx!4v1697744158453!5m2!1ses-419!2smx" width="auto" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                            <div class="col-6">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3733.820600785!2d-103.33754502316013!3d20.636168001143794!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8428b24486035b71%3A0xde42c7226e5a6992!2sTunali%20Tec!5e0!3m2!1ses-419!2smx!4v1697744198013!5m2!1ses-419!2smx" width="auto" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
