@section('navbar')
<ul style="display: flex; justify-content: space-between; align-items: center; list-style-type: none; margin: 0; padding: 0;">      

@if(auth()->check())
    <li class="aside a {{ Request::is('profeature*') || Request::is('projects*') || Request::is('sprint*') || Request::is('userstory*') ? 'active' : '' }}"><a href="{{ route('profeature.index') }}">Project List</a></li>
    
    <li class="aside a {{ Request::is('team*') ? 'active' : '' }}"><a href="{{ route('team.index') }}">Team</a></li>
    
    <li class="aside a {{ Request::is('status*') ? 'active' : '' }}"><a href="{{ route('status.index') }}">Status</a></li>
    
    <li class="aside a {{ Request::is('perfeature*') ? 'active' : '' }}"><a href="{{ route('perfeature.index') }}">Performance Feature</a></li>
    
    <li class="aside a {{ Request::is('secfeature*') ? 'active' : '' }}"><a href="{{ route('secfeature.index') }}">Security Feature</a></li>
    
    <li class="aside a {{ Request::is('codestand*') ? 'active' : '' }}"><a href="{{ route('codestand.index') }}">Coding Standard</a></li>
    
    @if(auth()->user()->role === 'admin')
        <li class="aside a {{ Request::is('role*') ? 'active' : '' }}"><a href="{{ route('role.index') }}">Role</a></li>
    @endif
    
    <li class="aside a" style="margin-left: auto; color: white;"><span>{{ auth()->user()->name }}</span></li>
    <li class="aside a"><a href="{{ url('/logout') }}">Logout</a></li>
@endif

</ul>
@endsection
