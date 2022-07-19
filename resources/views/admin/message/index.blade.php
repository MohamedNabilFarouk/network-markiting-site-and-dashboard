@extends('admin.layouts.app')


@section('toolbar')
<div class="toolbar" id="kt_toolbar">
    <!--begin::Container-->
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <!--begin::Page title-->
        <div class="d-flex align-items-center me-3">
            <!--begin::Title-->
            <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">الرسائل
            <!--begin::Separator-->
            <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
            <!--end::Separator-->
            <!--begin::Description-->
            <small class="text-muted fs-7 fw-bold my-1 ms-1"></small>
            <!--end::Description--></h1>
            <!--end::Title-->
        </div>
        <!--end::Page title-->

    </div>
    <!--end::Container-->
</div>
@endsection

@section('content')
@include('admin.includes.messages')

<div class="card rounded mb-5 mb-xl-8 shadow-lg">
    <!--begin::Header-->
    <div class="card-header rounded border-0 pt-5">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bolder fs-3 mb-1">كل الرسائل</span>
        </h3>

    </div>
    <!--end::Header-->
    <!--begin::Body-->
    <div class="card-body py-3">
        <!--begin::Table container-->
        <div class="table-responsive rounded">
            <!--begin::Table-->
            <table class="table table-hover align-middle gs-0 gy-4">
                <!--begin::Table head-->
                <thead>
                    <tr class="text-center border-3 fw-bolder text-muted bg-light">

                        <th class="min-w-125px">الاسم</th>
                        <th class="min-w-125px">البريد الاكتروني</th>
                        <th class="min-w-125px">الرسالة</th>
                        <th class="min-w-125px">التاريخ</th>
                        <th class="min-w-125px"></th>

                    </tr>
                </thead>
                <!--end::Table head-->
                <!--begin::Table body-->
                <tbody>
                @foreach($messages as $c)
                    <tr class="text-center border-3 m-auto">
                         <td class="px-3">
                            <div class="d-flex align-items-center">

                                <div class="d-flex flex-column">
                                    <a href="#" class="text-dark fw-bolder text-hover-primary mb-1 fs-6">{{$c->name}}</a>
                                </div>
                            </div>
                        </td>

                         <td class="px-3">
                            <div class="d-flex align-items-center">

                                <div class="d-flex flex-column">
                                    {{$c->email}}
                                </div>
                            </div>
                        </td>


                         <td class="px-3">
                            <div class="d-flex align-items-center">

                                <div class="d-flex flex-column">
                                    {{$c->message}}
                                </div>
                            </div>
                        </td>

                         <td class="px-3">
                            <div class="d-flex align-items-center">

                                <div class="d-flex flex-column">
                                    {{($c->created_at)->diffForHumans()}}

                                </div>
                            </div>
                        </td>










                        <td >


                            <form action="{{ route('message.destroy', $c->id) }}" method="post" id='delform' style="display: inline-block">
                                @csrf
                                @method('delete')


                                <button type="submit" class="btn btn-defult btn-xs delete" style='width:20px'><i class="fa fa-trash"></i> </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
                <!--end::Table body-->
            </table>
            <!--end::Table-->
        </div>
        <!--end::Table container-->
    </div>
    <!--begin::Body-->
</div>
<!--end::Tables Widget 11-->
@endsection



	<!--begin::Tables Widget 11-->
