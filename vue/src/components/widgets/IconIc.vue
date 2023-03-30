<template>
  <div class='svgContentClass' v-html="svgContent"></div>
</template>

<style scoped>
.svgContentClass{
  display:flex;
  justify-content: center;
  align-items: center;
}
</style>
<script>
export default {
  name: "IconIc",
  data() {
    return {
      svgContent: ''
    }
  },
  props: {
    width: {
      type: String,
      required: true
    },
    height: {
      type: String,
      required: true
    },
    fillColor: {
      type: String,
      required: true
    },
    svgPath: {
      type: String,
      required: true
    }
  },
  mounted() {
    const svgFilePath = require(`@/assets/icons/${this.svgPath}.svg`);
    const xhr = new XMLHttpRequest();
    xhr.open('GET', svgFilePath, true);
    xhr.onreadystatechange = () => {
      if (xhr.readyState === 4 && xhr.status === 200) {
        const svgData = xhr.responseText;
        const parser = new DOMParser();
        const svgElement = parser.parseFromString(svgData, 'image/svg+xml').documentElement;
        svgElement.setAttribute('width', this.width);
        svgElement.setAttribute('height', this.height);
        svgElement.setAttribute('stroke', this.fillColor);
        svgElement.setAttribute('style', 'vertical-align:middle; margin-right:20px; margin-top:-3px')
        this.svgContent = svgElement.outerHTML;
      }
    };
    xhr.send();
  },
};
</script>
