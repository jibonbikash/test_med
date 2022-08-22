@extends('layouts.app')

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Products</h1>
    </div>


    <div class="card">
        <form action="" method="get" class="card-header">
            <div class="form-row justify-content-between">
                <div class="col-md-2">
                    <input type="text" name="title" placeholder="Product Title" class="form-control" value="{{ request()->get('title') }}">
                </div>
                <div class="col-md-2">
                    <select name="variant" class="form-control" style="width: 100%">
                        <option value="">Select Variant </option>
                        @foreach($variants as $variant)
                            <optgroup label="{{ $variant->title }}">
                                @foreach($variant->ProductVariants as $varint)
                            <option value="{{ $varint->variant }}">{{ $varint->variant }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach

                    </select>
                </div>

                <div class="col-md-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Price Range</span>
                        </div>
                        <input type="text" name="price_from" aria-label="First name" placeholder="From" value="{{ request()->get('price_from') }}" class="form-control">
                        <input type="text" name="price_to" aria-label="Last name" placeholder="To" value="{{ request()->get('price_to') }}"  class="form-control">
                    </div>
                </div>
                <div class="col-md-2">
                    <input type="date" name="cdate" placeholder="Date" value="{{ request()->get('cdate') }}" class="form-control">
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary float-right"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>

        <div class="card-body">
            <div class="table-response">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Variant</th>
                        <th width="150px">Action</th>
                    </tr>
                    </thead>

                    <tbody>

                    @foreach($products as $product)
                        <tr>
                            <td>{{ ++$loop->index }}</td>
                            <td>{{ $product->title }} <br> Created at
                                : {{ \Carbon\Carbon::parse($product->from_date)->format('j-M-Y')}}</td>
                            <td>{{ Illuminate\Support\Str::limit($product->description, 50) }}
                            </td>
                            <td>
                                @foreach($product->variantprices as $variantprices)

                                @endforeach
                                <dl class="row mb-0" style="height: 80px; overflow: hidden"
                                    id="variant{{$product->id}}">
                                    @foreach($product->variantprices as $variantprices)
                                        <dt class="col-sm-3 pb-0">
                                            {{ $variantprices->product_variantone ? $variantprices->product_variantone->variant:'' }}
                                            {{ $variantprices->product_varianttwo ? '/'.$variantprices->product_varianttwo->variant:'' }}
                                            {{ $variantprices->product_variantthree ? '/'.$variantprices->product_variantthree->variant:'' }}
                                        </dt>
                                        <dd class="col-sm-9">
                                            <dl class="row mb-0">
                                                <dt class="col-sm-4 pb-0">Price
                                                    : {{ number_format($variantprices->price,2) }}</dt>
                                                <dd class="col-sm-8 pb-0">InStock
                                                    : {{ number_format($variantprices->stock,2) }}</dd>
                                            </dl>

                                        </dd>
                                    @endforeach
                                </dl>
                                <button onclick="$('#variant{{$product->id}}').toggleClass('h-auto')"
                                        class="btn btn-sm btn-link">Show more
                                </button>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('product.edit', $product->id) }}" class="btn btn-success">Edit</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>

        </div>

        <div class="card-footer">
            <div class="row justify-content-between">
                <div class="col-md-6">
                    <p>Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} out of {{$products->total()}}</p>
                </div>
                <div class="col-md-6">
                    {{ $products->appends(Request::all())->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection
