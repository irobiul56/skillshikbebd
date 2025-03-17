<script setup>
import { ref, onMounted, onBeforeUnmount } from "vue";

const editorInstance = ref(null);

onMounted(() => {
  import("https://cdn.jsdelivr.net/npm/@editorjs/editorjs@latest").then(
    ({ default: EditorJS }) => {
      editorInstance.value = new EditorJS({
        holder: "editorjs",
        tools: {
          header: {
            class: window.Header,
            inlineToolbar: true,
          },
          list: {
            class: window.List,
            inlineToolbar: true,
          },
        },
      });
    }
  );
});

onBeforeUnmount(() => {
  if (editorInstance.value) {
    editorInstance.value.destroy();
    editorInstance.value = null;
  }
});
</script>

<template>
  <div>
    <div id="editorjs" class="border p-2 rounded"></div>
  </div>
</template>

<style>
#editorjs {
  min-height: 300px;
  background: #fff;
}
</style>
