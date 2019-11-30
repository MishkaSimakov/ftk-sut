<div class="teacher-card">
    <img class="teacher-card__photo rounded-circle"
         src="{{ $teacher->avatar }}"
         alt="{{ $teacher->full_name }}"
         width="140"
         height="140"
    >
    <h3 class="teacher-card__name">{{ $teacher->full_name }}</h3>
    <p class="teacher-card__job-title">{{ $teacher->job_title }}</p>
</div>

