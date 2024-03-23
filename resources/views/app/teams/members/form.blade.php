
<div class="card">
    <h4 class="card-header">
        {{$data->name}}
    </h4>
    <livewire:team.members.form :team="$data->id" />
</div>
