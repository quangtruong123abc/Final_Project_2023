@extends('admin.layouts.app')

@section('content')
	<!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
	<div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">{{ __('admin.detailTransaction') }}</h4>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ url('/admin/dashboard') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('admin.detailTransaction') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-12">
                        <div class="card">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name Product</th>
                                            <th scope="col" >Quantity</th>
                                            <th scope="col">Price</th>
                                         </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($invoiceDetail as $key => $value)
                                        <tr>
                                            <th scope="row">{{$key + 1}}</th>
                                            <td>{{$value['name_product']}}</td>
                                            <td >{{$value['quantity']}}</td>
                                            <td>{{$value['price']}}</td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div style="float: right; margin-right: 10px;">
                                    {{-- {{ $getInvoice->links() }} --}}

                            </div>


                            </div>
                        </div>
            </div>
        </div>
    </div>
     <!-- end Container fluid  -->
@endsection
