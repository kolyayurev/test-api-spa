Hello {{ $model->name }}

Answer: {{ $model->status()->getCustomProperty('comment') }}
