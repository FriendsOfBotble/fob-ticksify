@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
    <div class="row">
        <div class="col-md-9">
            @if($ticket->is_resolved)
                <x-core::alert
                    type="success"
                    :title="trans('plugins/fob-ticksify::ticksify.resolved_message')"
                />
            @endif
            <x-core::card class="mb-3">
                <x-core::card.header class="justify-content-between">
                    <x-core::card.title>
                        {{ $ticket->title }}
                    </x-core::card.title>
                    {!! $ticket->status->toHtml() !!}
                </x-core::card.header>

                <x-core::card.body>
                    {!! BaseHelper::clean($ticket->content) !!}
                </x-core::card.body>
            </x-core::card>

            <x-core::card class="mb-3">
                <x-core::card.header>
                    <x-core::card.title>
                        {{ trans('plugins/fob-ticksify::ticksify.reply') }}
                    </x-core::card.title>
                </x-core::card.header>

                <x-core::card.body>
                    @if($ticket->is_locked)
                        <x-core::alert
                            type="warning"
                            :title="trans('plugins/fob-ticksify::ticksify.locked_message')"
                        />
                    @endif

                    {!! $messageForm->renderForm() !!}
                </x-core::card.body>
            </x-core::card>

            @if($messages->isNotEmpty())
                <x-core::card class="mb-3">
                    <x-core::card.header>
                        <x-core::card.title>
                            {{ trans('plugins/fob-ticksify::ticksify.replies') }}
                        </x-core::card.title>
                    </x-core::card.header>

                    <x-core::card.body class="scrollable">
                        <div class="chat">
                            <div class="chat-bubbles">
                                @foreach($messages as $message)
                                    <div class="chat-item">
                                        <div class="row align-items-end">
                                            <div class="col-auto">
                                                <span class="avatar" style="background-image: url('{{ $message->sender->avatar_url }}')"></span>
                                            </div>
                                            <div class="col">
                                                <div class="chat-bubble">
                                                    <div class="chat-bubble-title">
                                                        <div class="row">
                                                            <div class="col chat-bubble-author">
                                                                {{ $message->sender->name }}
                                                                @if($message->is_staff)
                                                                    <x-core::badge
                                                                        color="primary"
                                                                        :label="trans('plugins/fob-ticksify::ticksify.staff')"
                                                                    />
                                                                @endif
                                                            </div>
                                                            <div class="col-auto chat-bubble-date" title="{{ $message->created_at->translatedFormat('d M Y H:i') }}">
                                                                {{ $message->created_at->diffForHumans() }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="chat-bubble-body">
                                                        {!! BaseHelper::clean($message->content) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </x-core::card.body>
                </x-core::card>

                <div class="d-flex justify-content-center">
                    {{ $messages->links() }}
                </div>
            @endif
        </div>

        <div class="col-md-3">
            <x-core::card>
                <div class="border-bottom p-3 mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <span class="avatar avatar-sm rounded" style="background-image: url('{{ $ticket->sender->avatar_url }}')"></span>
                        <div>
                            <h5 class="mb-0 fs-4 text-body">{{ $ticket->sender->name }}</h5>
                            <a class="text-muted small" href="mailto:{{ $ticket->sender->email }}">{{ $ticket->sender->email }}</a>
                        </div>
                    </div>
                </div>
                <x-core::card.body>
                    <dl class="row">
                        <dt class="col-5">{{ trans('plugins/fob-ticksify::ticksify.ticket_id') }}:</dt>
                        <dd class="col-7">#{{ $ticket->getKey() }}</dd>
                        <dt class="col-5">{{ trans('plugins/fob-ticksify::ticksify.priority') }}:</dt>
                        <dd class="col-7">{!! $ticket->priority->toHtml() !!}</dd>
                        <dt class="col-5">{{ trans('plugins/fob-ticksify::ticksify.category') }}:</dt>
                        <dd class="col-7">{{ $ticket->category->name }}</dd>
                        <dt class="col-5">{{ trans('plugins/fob-ticksify::ticksify.created_at') }}:</dt>
                        <dd class="col-7">
                            <time title="{{ $ticket->created_at->translatedFormat('d M Y H:i') }}">{{ $ticket->created_at->diffForHumans() }}</time>
                        </dd>
                        <dt class="col-5">{{ trans('plugins/fob-ticksify::ticksify.updated_at') }}:</dt>
                        <dd class="col-7">
                            <time title="{{ $ticket->updated_at->translatedFormat('d M Y H:i') }}">{{ $ticket->updated_at->diffForHumans() }}</time>
                        </dd>
                    </dl>
                </x-core::card.body>
                <x-core::card.footer>
                    <x-core::button
                        type="button"
                        color="primary w-100"
                        data-bs-toggle="modal"
                        data-bs-target="#update-ticket-modal"
                    >
                        {{ trans('plugins/fob-ticksify::ticksify.update_ticket') }}
                    </x-core::button>
                </x-core::card.footer>
            </x-core::card>
        </div>
    </div>
@endsection

@push('footer')
    <x-core::modal
        id="update-ticket-modal"
        size="lg"
        :title="trans('plugins/fob-ticksify::ticksify.update_ticket')"
    >
        {!! $ticketForm->renderForm() !!}
        <x-slot:footer>
            <x-core::button data-bs-dismiss="modal" type="button">
                {{ trans('core/base::base.close') }}
            </x-core::button>
            <x-core::button type="submit" color="primary" class="ms-auto" form="ticket-form">
                Update
            </x-core::button>
        </x-slot:footer>
    </x-core::modal>
@endpush
