@extends('admin.layouts.app')

@section('content')
	<!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
	<div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">{{ __('admin.listTransaction') }}</h4>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ url('/admin/dashboard') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('admin.listTransaction') }}</li>
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
                                            <th scope="col">Invoice Code</th>
                                            <th scope="col">Total Money</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Phone</th>
                                            <th scope="col">Action</th>
                                         </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($getInvoice as $key => $value)
                                        <tr>
                                            <th scope="row">{{$key + 1}}</th>
                                            <td>{{$value['invoice_code']}}</td>
                                            <td>{{$value['total_money']}}</td>
                                            <td>{{$value['name']}}</td>
                                            <td>{{$value['phone']}}</td>
                                            <td>
                                                <a class="sidebar-link  waves-dark sidebar-link" href="{{ url('/admin/transaction/view/'.$value['id']) }}" aria-expanded="false">
                                                    <i class="mdi mdi-eye">View</i>
                                                </a>
                                            </td>
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
