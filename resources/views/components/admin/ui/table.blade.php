@props([
    'headers' => [],
    'striped' => false,
    'hover' => true
])

<div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
    <div class="overflow-x-auto">
        <table {{ $attributes->merge(['class' => 'min-w-full divide-y divide-gray-200']) }}>
            @if(count($headers) > 0)
                <thead class="bg-gray-50">
                    <tr>
                        @foreach($headers as $header)
                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                {{ $header }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
            @elseif(isset($head))
                <thead class="bg-gray-50">
                    {{ $head }}
                </thead>
            @endif
            
            <tbody class="divide-y divide-gray-100 {{ $striped ? 'bg-white' : '' }}">
                {{ $slot }}
            </tbody>
            
            @if(isset($foot))
                <tfoot class="bg-gray-50">
                    {{ $foot }}
                </tfoot>
            @endif
        </table>
    </div>
</div>
