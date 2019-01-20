@extends('layouts.dashboard', ['pageTitle' => 'Photos', 'pageCode' => 'photo'])

@section('content')
    <div class="border-bottom">
        @forelse(Auth::user()->devices as $device)
            <div class="devices-container">
                <a href="{{ route('dashboard-photo-device', ['id' => $device->device_id]) }}">
                    <div class="device-container">
                        <span>{{ $device->device_name }}</span>
                    </div>
                </a>
            </div>
        @empty
            <p>
                Vous n'avez pas encore enregistré de dispositif.
            </p>
        @endforelse
    </div>
@endsection