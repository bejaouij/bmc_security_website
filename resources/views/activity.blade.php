@php
    function buttonTypeByStatusCode($statusCode) : String {
        $buttonTypes = [
            '0' => 'success',
            '1' => 'warning',
            '2' => 'danger',
            '3' => 'info'
        ];

        return isset($buttonTypes[$statusCode]) ? $buttonTypes[$statusCode] : 'dark';
    }
@endphp

@extends('layouts.dashboard', ['pageTitle' => 'Activité', 'pageCode' => 'activity'])

@section('content')
    <div class="border-bottom">
        @forelse($activities as $activity)
            <div class="alert alert-{{ buttonTypeByStatusCode($activity->activity_type) }} d-flex justify-content-between" role="alert">
                <div>
                    {{ $activity->activity_label }}
                </div>

                <div>
                    {{ $activity->formattedDate }}
                </div>
            </div>
        @empty
            <p>
                Rien à signaler.
            </p>
        @endforelse

        <nav class="d-flex justify-content-center">
            <ul class="pagination">
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">&lt;</a>
                </li>

                <li class="page-item active" aria-current="page">
                    <a class="page-link" href="#">1<span class="sr-only">(current)</span></a>
                </li>

                <li class="page-item disabled">
                    <a class="page-link" href="#">&gt;</a>
                </li>
            </ul>
        </nav>
    </div>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
        <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#exampleModal">Télécharger un rapport</button>
    </div>
@endsection