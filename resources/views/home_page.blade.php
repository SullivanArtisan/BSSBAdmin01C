@extends('layouts.home_page_base')
@section('function_page')
    <div class="card mx-2 mt-3" style="background-color: #A9DFBF;">
        <div class="card-body">
            <h3 class="card-title text-primary">Hi, <span style="font-family: 'Times New Roman';font-weight: bold;font-style: italic;">{{Auth::user()->name}}</span>, welcome to HarbourLink's Home!</h4>
            <!--
            <p class="card-text">The functions in this group are good for H/L control options</p>
            -->
        </div>
    </div>
    <div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="w-25">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="mx-2 mb-4 card-title text-center text-info">H/L Control Options</h4>
                                <div class="vstack">
                                    <div><button class="btn btn-outline-secondary btn-block" type="button" style="margin: 6px;">Enter New Job</button></div>
                                    <div><button class="btn btn-outline-secondary btn-block" type="button" style="margin: 6px;">Dispatch</button></div>
                                    <div><button class="btn btn-outline-secondary btn-block" type="button" style="margin: 6px;">Bookings</button></div>
                                    <div><button class="btn btn-outline-secondary btn-block" type="button" style="margin: 6px;">Containers</button></div>
                                    <div><button class="btn btn-outline-secondary btn-block" type="button" style="margin: 6px;">Chassis</button></div>
                                    <div><button class="btn btn-outline-secondary btn-block" type="button" style="margin: 6px;">Power Units</button></div>
                                    <div><button class="btn btn-outline-secondary btn-block" type="button" style="margin: 6px;">Predispatch Screen</button></div>
                                    <div><button class="btn btn-outline-secondary btn-block" type="button" style="margin: 6px;">New Chassis Database</button></div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="w-25">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="mx-2 mb-4 card-title text-center text-info">TCEF Options</h4>
                                <div class="vstack">
                                    <div><button class="btn btn-outline-secondary btn-block" type="button" style="margin: 6px;">Enter CBSA Job</button></div>
                                    <div><button class="btn btn-outline-secondary btn-block" type="button" style="margin: 6px;">View CBSA Jobs</button></div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="w-25">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="mx-2 mb-4 card-title text-center text-info">Admin Options</h4>
                                <div class="vstack">
                                    <div><button class="btn btn-outline-secondary btn-block" type="button" style="margin: 6px;">Driver Pay List</button></div>
                                    <div><button class="btn btn-outline-secondary btn-block" type="button" style="margin: 6px;">Invoice Jobs List</button></div>
                                    <div><button class="btn btn-outline-secondary btn-block" type="button" style="margin: 6px;">Customer Search</button></div>
                                    <div><button class="btn btn-outline-secondary btn-block" type="button" style="margin: 6px;">Driver Search</button></div>
                                    <div><button class="btn btn-outline-secondary btn-block" type="button" style="margin: 6px;">Create Manual Invoice</button></div>
                                    <div><button class="btn btn-outline-secondary btn-block" type="button" style="margin: 6px;">View Manual Invoice</button></div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
