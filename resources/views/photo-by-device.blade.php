@extends('layouts.dashboard', ['pageTitle' => 'Photos', 'pageCode' => 'photo'])

@section('content')
    <div class="border-bottom">
        <div class="photos-container">
            @forelse($device->photos as $photo)
                <div>
                    <div class="photo-container" style="background-image: url({{ asset('media/device') . '/' . $photo->photo_relative_path }})" data-toggle="modal" data-target="#bigger-photo-container"
                         onclick="event.preventDefault();
                                 $(this.getAttribute('data-target')).modal('show');
                                 $(this.getAttribute('data-target') + ' div.modal-footer p')[0].innerHTML = '{{ $photo->formattedDate }}';
                                 document.querySelector(this.getAttribute('data-target') + ' div.modal-body').style.backgroundImage = 'url(\'{{ asset('media/device') . '/' . $photo->photo_relative_path }}\')'">
                    </div>

                    <p class="photo-date">{{ $photo->formattedDate }}</p>
                </div>
            @empty
                <p>
                    Le dispositif {{ $device->device_name }} n'a encore pris aucune photo.
                </p>
            @endforelse
        </div>
    </div>

    <div class="modal fade" id="bigger-photo-container" tabindex="-1" role="dialog" aria-labelledby="bigger-photo-container-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                </div>

                <div class="modal-footer">
                    <p></p>
                </div>
            </div>
        </div>
    </div>
@endsection