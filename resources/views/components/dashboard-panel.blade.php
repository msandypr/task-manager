@props(['attributeContent', 'attributeName', 'fontName'])

<div class="w-full md:w-1/2 xl:w-1/3 p-1">
    <div class="bg-white border border-gray-200 rounded-lg shadow-xl p-5">
        <div class="flex items-center">
            <div class="flex-shrink-0 mr-4">
                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-blue-600">
                    <i class="fas fa-{{$fontName}} text-white fa-2x"></i>
                </div>
            </div>
            <div class="flex-1">
                <h5 class="font-semibold text-gray-600">{{$attributeName}}</h5>
                <h3 class="text-2xl font-bold">{{$attributeContent}}</h3>
            </div>
        </div>
    </div>
</div>
