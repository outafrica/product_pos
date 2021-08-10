<!-- Import header -->
@include('includes.header')     

    <div id="app">

    <!-- <dashboard></dashboard> -->
            
        @if(Auth::check())
            <dashboard :user="{{Auth::user()}}"></dashboard>
        @else
            <login></login>
        @endif

    </div>

<!-- Import footer -->
@include('includes.footer')
