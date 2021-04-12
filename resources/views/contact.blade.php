@extends('layouts.app', ['activePage' => 'contacto', 'titlePage' => __('Contacto')])

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
                        <div class="col-md-6">
                            <div class="fancy-title">
                                <h3>TunaliTec Guadalajara</h3>
                            </div>
                            <p>Parque Industrial Cañas, Avenida Cañas 3250 Bodega 14, Entre Lazaro Cardenas y Av. Cañas, La Nogalera, 44470 Guadalajara, Jal.</p>
                        </div><br>
                            <div class="col-md-6">
                        <div class="fancy-title">
                            <h3>TunaliTec Cuernavaca</h3>
                        </div>
                            <p>Calle 40 - Sur MZ 8, LT 8-B, Civac, 62500 Cuernavaca, Mor.</p>
                        </div>
                        </div>
                        <div class="col-md-6"><br>
                            <h4>TunaliTec México</h4><br>
                            <div itemscope itemtype="http://schema.org/LocalBussiness">
                                <a href="tel:018000088625" itemprop="telephone" title="Teléfono Cuernavaca"><p><span class="material-icons">phone</span>&nbsp;&nbsp;&nbsp;Cuernavaca: (777) 176 14 15 </p></a>

                                <a href="tel:7773620636" itemprop="telephone" title="Teléfono CDMX"><p><span class="material-icons">phone</span>&nbsp;&nbsp;&nbsp;CDMX: (55) 88 54 71 33
                                    </p></a>

                                <a href="tel:3336573660" itemprop="telephone" title="Teléfono Guadalajara"><p><span class="material-icons">phone</span>&nbsp;&nbsp;&nbsp;Guadalajara: (33) 15 80 06 01</p></a>

                                <a href="mailto:informes@tunalitec.com" itemprop="email" title="Email"><p><span class="material-icons">email</span>&nbsp;&nbsp;&nbsp;Correo: informes@tunalitec.com</p></a>
                                <a href="http://www.tunalitec.com"><p><span class="material-icons">public</span>&nbsp;&nbsp;&nbsp;Sitio Web: www.tunalitec.com</p></a>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
