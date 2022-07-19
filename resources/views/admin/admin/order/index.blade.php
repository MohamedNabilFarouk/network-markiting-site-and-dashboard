@extends('admin.layouts.app')


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


@section('toolbar')
<div class="toolbar" id="kt_toolbar">
    <!--begin::Container-->
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <!--begin::Page title-->
        <div class="d-flex align-items-center me-3">
            <!--begin::Title-->
            <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">{{__('site.Orders')}}
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

<div class="card rounded mb-5 mb-xl-8 shadow-lg">
    <!--begin::Header-->
    <div class="card-header rounded border-0 pt-5">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bolder fs-3 mb-1">{{__('site.All Orders')}}</span>
        </h3>

    </div>
    <!--end::Header-->
    <!--begin::Body-->
    <div class="card-body py-3">

        @include('admin.includes.messages')

        <!--begin::Table container-->
        <div class="table-responsive rounded">
            <!--begin::Table-->
            <table class="table table-hover align-middle gs-0 gy-4">
                <!--begin::Table head-->
                <thead>
                    <tr class="text-center border-3 fw-bolder text-muted bg-light">
                        <th class="min-w-125px">{{__('site.Order No')}}</th>
                        <th class="min-w-125px">{{__('site.Product')}}</th>
                        <th class="min-w-125px">{{__('site.Date')}}</th>

                        <th class="min-w-125px">{{__('site.Customer')}}</th>
                        <th class="min-w-125px">{{__('site.Customer Phone')}}</th>
                        <th class="min-w-125px">{{__('site.Used Code')}}</th>
                        <!-- <th class="min-w-125px">@lang('site.Type')</th> -->
                        <th class="min-w-125px">{{__('site.Address')}}</th>
                        <th class="min-w-125px">{{__('site.Total')}}</th>

                        <th class="min-w-150px">{{__('site.Status')}}</th>
                        <!-- <th class="min-w-150px">@lang('site.Assign To')</th> -->
                        <th class="min-w-200px text-start rounded-end">{{__('site.Action')}}</th>
                    </tr>
                </thead>
                <!--end::Table head-->
                <!--begin::Table body-->
                <tbody>
                @foreach($orders as $index => $c)
                    <tr class="text-center border-3 m-auto">
                         <td class="px-3">
                       <span class="text-dark fw-bolder text-hover-primary mb-1 fs-6">{{$c->id}}</span>
                        </td>


                        <td class="px-3">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-50px me-5">
                                    <img src="{{$c->product->image}}" class="" alt="" />
                                </div>
                                <div class="d-flex flex-column">
                                    <a href="#" class="text-dark fw-bolder text-hover-primary mb-1 fs-6">{{$c->product->name}}</a>

                                </div>
                            </div>
                        </td>


                         <td class="px-3">
                        <span class="text-muted fw-bold text-muted d-block fs-7">{{$c->created_at}}</span>
                        </td>

                         <td class="px-3">

                       <span class="text-dark fw-bolder text-hover-primary mb-1 fs-6">{{$c->user->name ?? ''}}</span>
                      <br> <span class="text-dark fw-bolder text-hover-primary mb-1 fs-6">{{$c->user->email ?? ''}}</span>

                       </td>


                        <td class="px-3">

                       <span class="text-dark fw-bolder text-hover-primary mb-1 fs-6">{{$c->user->phone ?? ''}}</span>

                       </td>
                        <td class="px-3">

                       <span class="text-dark fw-bolder text-hover-primary mb-1 fs-6">{{$c->code ?? ''}}</span>

                       </td>



                        <td class="px-3">

                       <span class="text-dark fw-bolder text-hover-primary mb-1 fs-6">{{$c->address ??''}}</span>

                       </td>

                        <td class="px-3">

                       <span class="text-dark fw-bolder text-hover-primary mb-1 fs-6">{{$c->total ?? ''}} LE</span>

                       </td>

                       <td class="px-3">

                        <span class="text-dark fw-bolder text-hover-primary mb-1 fs-6">@if($c->is_paid == 1) Paid @else Unpaid @endif </span>

                        </td>




                        <td class="text-start">



                            <form action="{{ route('order.destroy', $c->id) }}" method="post" id='delform' style="display: inline-block">
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
{!! $orders->render() !!}

@endsection
