<?php
theme_enqueue_style('modal');
$defaults = [
    'id' => '',
    'title' => '',
    'content' => '',
    'icon' => '',
    'show_after' => false,
    'close_by_away_click' => true
];
$args = wp_parse_args($args ?? [], $defaults);

if (empty($args['id'])) {
    return;
}
?>
<div x-ref="<?= esc_attr($args['id']) ?>" <?php if (!empty($args['show_after'])) { ?>
        x-init="window.setTimeout(() => (modals.<?= esc_attr($args['id']) ?> = true), <?= intval($args['show_after']) ?> ) "
    <?php } ?> <?php if ($args['close_by_away_click']) { ?>
        @keydown.window.escape="modals.<?= esc_attr($args['id']) ?> = false" <?php } ?> <?php // x-init="$watch(&quot;open&quot;, o => !o &amp;&amp; window.setTimeout(() => (open = true), 1000))" ?>
    x-show="modals.<?= esc_attr($args['id']) ?>" class="modal relative z-[999]"
    aria-labelledby="modal-title-<?= esc_attr($args['id']) ?>" aria-modal="true" x-cloak
    @modal-show="modals.<?= esc_attr($args['id']) ?> = true">

    <div x-show="modals.<?= esc_attr($args['id']) ?>" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" x-description="Background backdrop, show/hide based on modal state."
        class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

    <div class="fixed z-[999] inset-0 overflow-y-auto">
        <div class="flex items-start sm:items-center justify-center min-h-full p-4 text-center">
            <div x-show="modals.<?= esc_attr($args['id']) ?>" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-description="Modal panel, show/hide based on modal state."
                class="relative bg-white rounded-3xl p-4 text-left shadow-xl transform transition-all sm:mx-5 sm:my-8 max-w-fit w-full"
                <?php if ($args['close_by_away_click']) { ?> @click.away="modals.<?= esc_attr($args['id']) ?> = false"
                <?php } ?>>
                <?php if ($args['close_by_away_click']) { ?>
                    <div class="block absolute top-0 right-0 pt-3 pr-3">
                        <button type="button"
                            class="bg-white rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            @click="modals.<?= esc_attr($args['id']) ?> = false">
                            <span class="sr-only">
                                <?= __('Close', 'dino') ?>
                            </span>
                            <svg class="h-8 w-8 sm:h-10 sm:w-10" x-description="Heroicon name: outline/x"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width=".75"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                <?php } ?>
                <div class="">
                    <?php if (!empty($args['icon'])) { ?>
                        <div class="modal__icon">
                            <?= $args['icon'] ?>
                        </div>
                    <?php } ?>
                    <div class="text-left">
                        <?php if (!empty($args['title'])) { ?>
                            <div class="modal__title h2" id="modal-title-<?= esc_attr($args['id']) ?>">
                                <?= $args['title'] ?>
                            </div>
                        <?php } ?>
                        <div class="modal__content">
                            <?= $args['content'] ?>
                        </div>
                    </div>
                </div>
                <?php
                /* <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                <button type="button"
                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm"
                @click="modals.<?=esc_attr($args['id'])?> = false"
                >
                Deactivate
                </button>
                <button
                type="button"
                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm"
                @click="modals.<?=esc_attr($args['id'])?> = false"
                >
                Cancel
                </button>
                </div>
                */?>

            </div>
        </div>
    </div>
</div>
<?php /*
 <button class="question__a-btn btn btn-lg btn-yellow"
 role="button" tabindex="-1"
 @click="modals.<?= esc_attr($args['id']) ?> = true"><?= esc_attr($args['id']) ?></button> */?>