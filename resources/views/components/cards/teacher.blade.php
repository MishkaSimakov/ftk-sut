<div class="teacher col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
    <img class="teacher__photo" style="object-fit: cover; object-position: top;" src="{{ optional($teacher->getMedia()->first())->getUrl() }}" alt="{{ $teacher->full_name }}">
    <p class="teacher__name">{{ $teacher->last_name }} {{ $teacher->first_name }}<br>{{ $teacher->middle_name }}</p>
    <p class="teacher__employment">Преподаватель в кружке "{{ $teacher->club->name }}"</p>
</div>
