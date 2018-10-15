<template>
    <div class="columns">
        <div class="column is-6-widescreen">
            <timeline
                v-if="$_auth.check"
                endpoint="/api/statuses"
                empty="There's nothing in your timeline yet."
                
                >
            </timeline>
            <template v-else>
                <h1 class="title">Welcom to Youpeng</h1>
                <p>The new generation social network.</p>
            </template>
        </div>
    </div>
</template>

<script>
import Timeline from '@/components/Timeline';

export default {
    components: { Timeline }
}
</script>

