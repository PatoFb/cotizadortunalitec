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
                        <div class="col-md-6 col-sm-12">
                            <div class="fancy-title">
                                <h3>Solair Cuernavaca</h3>
                            </div>
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3774.25297806483!2d-99.17428632479847!3d18.920193382252556!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85ce7574fe25a61f%3A0x94cad193501586fa!2sToldos%20Solair%20M%C3%A9xico!5e0!3m2!1ses-419!2smx!4v1697744158453!5m2!1ses-419!2smx" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                            <br>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6"><br>
                            <h4>Tunalitec México</h4><br>
                            <div itemscope itemtype="http://schema.org/LocalBussiness">
                                <a href="tel:7771761415" itemprop="telephone" title="Teléfono Solair"><p><span class="material-icons">phone</span>&nbsp;&nbsp;&nbsp;Solair: (55) 5022 7087 </p></a>

                                <a href="tel:8007865367" itemprop="telephone" title="Teléfono Solair 800"><p><span class="material-icons">phone</span>&nbsp;&nbsp;&nbsp;Solair 800: (800) 786 5367
                                    </p></a>

                                <a href="mailto:ventas@solairmexico.com" itemprop="email" title="Email"><p><span class="material-icons">email</span>&nbsp;&nbsp;&nbsp;Correo: ventas@solairmexico.com</p></a>
                                <a href="http://www.solairmexico.com" target="_blank"><p><span class="material-icons">public</span>&nbsp;&nbsp;&nbsp;Sitio Web: www.solairmexico.com</p></a>

                            </div>

                        </div>

                        <div class="col-md-6 col-sm-6"><br>
                            <h4>Redes sociales</h4><br>
                            <div itemscope itemtype="http://schema.org/LocalBussiness">
                                <a href="https://www.facebook.com/ToldosSolairMexico/?ref=hl" title="facebook" aria-label="facebook" target="_blank"><p><span class="fa fa-facebook"></span>&nbsp;&nbsp;&nbsp;facebook</p></a>

                                <a href="https://www.linkedin.com/showcase/toldos-solair-mexico/about/"  title="linkedin" aria-label="linkedin" target="_blank"><p><span class="fa fa-linkedin"></span>&nbsp;&nbsp;&nbsp;linkedin</p></a>

                                <a href="https://wa.me/527775178973" title="whatsapp" aria-label="whatsapp"><p><span class="fa fa-whatsapp" target="_blank"></span>&nbsp;&nbsp;&nbsp;WhatsApp</p></a>

                                <a href="https://www.instagram.com/toldos.solair/"  title="instagram" aria-label="instagram" target="_blank"><p><span class="fa fa-instagram"></span>&nbsp;&nbsp;&nbsp;Instagram</p></a>

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
