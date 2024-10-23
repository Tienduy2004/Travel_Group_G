@extends('layouts.admin_app')
@section('content')
    <!-- Main content -->
    <main role="main" class="col-md-10 ml-sm-auto px-4 py-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Dashboard</h1>
            <div class="d-flex align-items-center">
                <input type="text" class="form-control mr-3" placeholder="Search anything">
                <i class="fas fa-bell mr-3 text-muted"></i>
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">RH</div>
            </div>
        </div>

        <!-- Stats -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card stat-card">
                    <div class="card-body">
                        <h3 class="card-title">Total Booking</h3>
                        <h2>1,200</h2>
                        <p class="mb-0">+2.98% from last month</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card">
                    <div class="card-body">
                        <h3 class="card-title">Total New Customers</h3>
                        <h2>2,845</h2>
                        <p class="mb-0 text-danger">-1.46% from last month</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card">
                    <div class="card-body">
                        <h3 class="card-title">Total Earnings</h3>
                        <h2>$12,890</h2>
                        <p class="mb-0">+3.75% from last month</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Revenue Overview</h5>
                        <div class="revenue-chart"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Top Destinations</h5>
                        <div class="d-flex justify-content-center mb-3">
                            <div class="pie-chart-placeholder"></div>
                        </div>
                        <div class="destinations">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tokyo, Japan</span>
                                <span>35%</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Sydney, Australia</span>
                                <span>28%</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Paris, France</span>
                                <span>22%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Travel Packages -->
        <h2 class="mb-3">Travel Packages</h2>
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="package-image" style="background-image: url('https://source.unsplash.com/random/400x200/?seoul');"></div>
                    <div class="card-body">
                        <h5 class="card-title">Seoul, South Korea</h5>
                        <p class="card-text">8 Days / 7 Nights</p>
                        <p class="package-price mb-0">$2,100</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="package-image" style="background-image: url('https://source.unsplash.com/random/400x200/?venice');"></div>
                    <div class="card-body">
                        <h5 class="card-title">Venice, Italy</h5>
                        <p class="card-text">8 Days / 7 Nights</p>
                        <p class="package-price mb-0">$1,500</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="package-image" style="background-image: url('https://source.unsplash.com/random/400x200/?serengeti');"></div>
                    <div class="card-body">
                        <h5 class="card-title">Serengeti, Tanzania</h5>
                        <p class="card-text">8 Days / 7 Nights</p>
                        <p class="package-price mb-0">$3,200</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Messages and Calendar -->
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Messages</h5>
                        <div class="message d-flex align-items-center mb-3">
                            <div class="message-avatar mr-3">E</div>
                            <div>
                                <h6 class="mb-0">Europia Hotel</h6>
                                <p class="mb-0 text-muted">We are pleased to provide you with...</p>
                            </div>
                        </div>
                        <div class="message d-flex align-items-center mb-3">
                            <div class="message-avatar mr-3">G</div>
                            <div>
                                <h6 class="mb-0">Global Travel Co</h6>
                                <p class="mb-0 text-muted">We have updated our cancellation...</p>
                            </div>
                        </div>
                        <div class="message d-flex align-items-center">
                            <div class="message-avatar mr-3">K</div>
                            <div>
                                <h6 class="mb-0">Kalendra Umbara</h6>
                                <p class="mb-0 text-muted">Hi, I need assistance with my...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">July 2023</h5>
                        <table class="table table-sm calendar">
                            <thead>
                                <tr>
                                    <th>Sun</th>
                                    <th>Mon</th>
                                    <th>Tue</th>
                                    <th>Wed</th>
                                    <th>Thu</th>
                                    <th>Fri</th>
                                    <th>Sat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>1</td>
                                    <td>2</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>4</td>
                                    <td>5</td>
                                    <td>6</td>
                                    <td>7</td>
                                    <td>8</td>
                                    <td>9</td>
                                </tr>
                                <tr>
                                    <td>10</td>
                                    <td>11</td>
                                    <td class="today">12</td>
                                    <td>13</td>
                                    <td>14</td>
                                    <td>15</td>
                                    <td>16</td>
                                </tr>
                                <tr>
                                    <td>17</td>
                                    <td>18</td>
                                    <td>19</td>
                                    <td>20</td>
                                    <td>21</td>
                                    <td>22</td>
                                    <td>23</td>
                                </tr>
                                <tr>
                                    <td>24</td>
                                    <td>25</td>
                                    <td>26</td>
                                    <td>27</td>
                                    <td>28</td>
                                    <td>29</td>
                                    <td>30</td>
                                </tr>
                                <tr>
                                    <td>31</td>
                                    <td></td>
                                    
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @endsection
