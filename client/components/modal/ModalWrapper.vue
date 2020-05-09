<template>
  <transition name="modal">
    <div class="modal-mask">
      <div class="modal-wrapper" @click.self="$emit('close')">
        <div class="modal-container">
          <div class="modal-header">
            <slot name="header"></slot>
          </div>
          <div class="modal-body">
            <slot name="body"></slot>
          </div>
          <div class="modal-footer">
            <slot name="footer"></slot>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
  export default {
    name: 'modal-wrapper',
    mounted() {
      // escキーでも閉じれるように設定
      document.body.addEventListener('keyup', e => {
        if (e.keyCode === 27) {
          this.$emit('close');
        }
      });
    },
  }
</script>

<style lang="scss" scoped>
  .modal-mask {
    position: absolute;
    z-index: 9998;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, .5);
    display: table;
    transition: opacity .3s ease;
  }

  .modal-wrapper {
    display: table-cell;
    vertical-align: middle;
  }

  .modal-container {
    width: 70%;
    margin: 0 auto;
    padding: 20px 30px;
    background-color: #fff;
    border-radius: 2px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
    transition: all .3s ease;
    font-family: Helvetica, Arial, sans-serif;
    max-height: 650px;
    overflow-y: auto;

    @media (max-width: 480px) {
      width: 100%;
    }
  }

  .modal-header {
    margin-top: 0;
    color: #42b983;
  }

  .modal-body {
    margin-top: 20px;
    min-height: 400px;
    padding: 0;
  }

  .modal-default-button {
    float: right;
  }

  .modal-enter,
  .modal-leave-active {
    opacity: 0;
  }

  .modal-enter .modal-container,
  .modal-leave-active .modal-container {
    -webkit-transform: scale(1.1);
    transform: scale(1.1);
  }

  .modal-footer {
    position: relative;
    top: 20px;
  }
</style>
