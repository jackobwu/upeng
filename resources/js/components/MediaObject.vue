<template>
    <article class="media">

        <figure class="media-left">
            <p :class="`image is-${imageSize}x${imageSize}`">
                <slot name="image"></slot>
            </p>
        </figure>

        <div class="meida-content">
            <div class="content">
                <slot name="content"></slot>
            </div>

            <nav v-if="this.$slots['actions']" class="level is-mobile">
                <div class="level-left">
                    <slot name="actions"></slot>
                </div>
            </nav>
        </div>

    </article>
</template>

<script>
export default {
    props: {
        imageSize: {
            type: Number,
            default: 48
        }
    }
}
</script>

