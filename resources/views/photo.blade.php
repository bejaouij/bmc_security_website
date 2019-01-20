@extends('layouts.dashboard', ['pageTitle' => 'Photos', 'pageCode' => 'photo'])

@section('content')
    <div class="border-bottom">
        <div class="devices-container">
            @forelse(Auth::user()->devices as $device)
                <a href="{{ route('dashboard-photo-device', ['id' => $device->device_id]) }}">
                    <div class="device-container">
                        <span>{{ $device->device_name }}</span>
                    </div>
                </a>
            @empty
                <p>
                    Vous n'avez pas encore enregistré de dispositif.
                </p>
            @endforelse
        </div>
    </div>
@endsection