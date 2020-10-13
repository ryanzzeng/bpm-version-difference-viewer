<template>
    <div v-if="changes.length">
        <heading class="text-2xl mb-6">
            Version Difference Viewer
        </heading>

        <header class="text-2xl mb-6 mt-4">
            From <label class="text-primary"> Version {{ published.version }}</label> To <label class="text-success"> Version {{ draft.version }} </label>
        </header>

        <div class="container bg-white">
            <div class="overflow-hidden overflow-x-auto relative">
                <table style="border-spacing: 0 0.75rem;">
                    <thead>
                    <tr>
                        <th class="border px-4 py-2">Entity</th>
                        <th class="border px-4 py-2">User</th>
                        <th class="border px-4 py-2">Action</th>
                        <th class="border px-4 py-2">Original</th>
                        <th class="border px-4 py-2">Changes</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="change in changes">
                        <td class="border px-4 py-2">{{ formatModelName(change.model_type) }}</td>
                        <td class="capitalize border px-4 py-2">{{ change.user.name }}</td>
                        <td class="border px-4 py-2">{{ change.name }}</td>
                        <td class="border px-4 py-2 w-1/4">
                            <v-json-viewer
                                :value="change.original"
                                boxed
                            />
                        </td>
                        <td class="border px-4 py-2 w-1/4">
                            <v-json-viewer
                                :value="change.changes"
                                boxed
                            />
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div v-else>
        <heading class="text-2xl mb-6 text-center text-black">
            No data available for Version Diff Viewer!
        </heading>
    </div>
</template>
<script>
import JsonViewer from 'vue-json-viewer';
export default {
    components: {
        'v-json-viewer': JsonViewer
    },
    data() {
        return {
            draft: null,
            published: null,
            changes: [],
        }
    },
    mounted() {
        this.getVersionDiff();
    },
    methods: {
        getVersionDiff() {
            Nova.request().get('/nova-vendor/version-difference-viewer/index').then(response => {
                this.changes = response.data.changes;
                this.draft = response.data.draft;
                this.published = response.data.draft.parent;
            }).catch(error => {
                console.log(error);
            });
        },
        formatModelName(model) {
            const spilt = model.split('\\');
            return spilt[2];
        }
    },
}
</script>
