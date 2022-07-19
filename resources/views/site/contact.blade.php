
@extends('site.master')
@section('content')
<!-- CONTACT SECTION -->
<section id="contact" class="parallax-section">
    @include('admin.includes.messages')
    <div class="container">
         <div class="row trans">

              <div class="col-md-12 col-sm-12">
                   <!-- SECTION TITLE -->
                   <div class="wow fadeInUp section-title" data-wow-delay="0.2s">
                        <h2>كن علي تواصل</h2>
                        {{-- <p>Get In Touch With Shiiry</p> --}}
                   </div>
              </div>

              <div class="col-md-7 col-sm-10">
                   <!-- CONTACT FORM HERE -->
                   <div class="wow fadeInUp" data-wow-delay="0.4s">
                       <form id="contact-form" action="{{route('sendMessage')}}" method="post">
                        @csrf
                             <div class="col-md-6 col-sm-6">
                                  <input type="text" class="form-control" name="name" placeholder="الاسم" required="">
                             </div>
                             <div class="col-md-6 col-sm-6">
                                  <input type="email" class="form-control" name="email" placeholder="البريد الاكتروني" required="">
                             </div>
                             <div class="col-md-12 col-sm-12">
                                  <textarea class="form-control" rows="5" name="message" placeholder="الرسالة" required=""></textarea>
                             </div>
                             <div class="col-md-offset-8 col-md-4 col-sm-offset-6 col-sm-6">
                                  <button id="submit" type="submit" class="form-control" name="submit">ارسل</button>
                             </div>
                       </form>
                   </div>
              </div>

              <div class="col-md-5 col-sm-8">
                   <!-- CONTACT INFO -->
                   <div class="wow fadeInUp contact-info" data-wow-delay="0.4s">
                        <div class="section-title">
                             <h3>معلومات التواصل</h3>
                             <p>في اي وقت</p>
                        </div>

                        <p><i class="fa fa-map-marker"></i> {{$site_settings->address_en}}</p>
                        <p><i class="fa fa-comment"></i> <a href="mailto:info@company.com">{{$site_settings->email}}</a></p>
                        <p><i class="fa fa-phone"></i> {{$site_settings->phone}}</p>
                   </div>
              </div>

         </div>
    </div>
</section>
@stop
