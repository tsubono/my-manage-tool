<template>
  <div class="card col-md-10 col-md-offset-1">
    <!-- .header -->
    <div class="header">
      <h4 class="title">取引先情報</h4>
    </div>
    <!-- /.header -->
    <!-- .content -->
    <div class="content">
      <!-- form items -->
      <div class="row">
        <!-- .icon-area -->
        <div class="icon-area col-md-4 col-xs-11 col-xs-offset-1">
          <img
            :src="$utility.getImageUrl(form.icon_path)"
            class="round-img big"
          >
          <file-uploader
            @on-change-file="onChangeFile"
          >
            <a class="edit-icon" slot="button">
              <span class="ti-pencil"></span>
            </a>
          </file-uploader>
        </div>
        <!-- /.icon-area -->
        <div class="col-md-7 col-xs-12">
          <fg-input
            type="text"
            class="col-md-8 col-xs-12"
            label="名前"
            v-model="form.name"
            :errors="errors.name"
          >
          </fg-input>
          <fg-input
            type="text"
            class="col-md-8 col-xs-12"
            label="住所"
            v-model="form.address"
            :errors="errors.address"
          >
          </fg-input>
          <fg-input
            type="text"
            class="col-md-8 col-xs-12"
            label="url"
            v-model="form.url"
            :errors="errors.url"
          >
          </fg-input>
        </div>
        <div class="form-group col-md-10 col-xs-12">
          <label>メモ</label>
          <textarea
            rows="5"
            class="form-control border-input"
            v-model="form.note"
            :errors="errors.note"
          >
          </textarea>
        </div>
        <div class="form-group col-md-10 col-xs-12">
          <fg-multi-select
            :labelOptions="labelOptions"
            open-direction="top"
            select-label="name"
            track-by="id"
            tag-placeholder="新しいラベルを作成"
            @add-label="addLabel"
            v-model="form.labels"
          >
          </fg-multi-select>
        </div>
      </div>
      <!-- /form items -->
      <!-- buttons -->
      <div class="text-center actions">
        <button class="btn btn-default" @click="$router.push('/clients')">
          一覧に戻る
        </button>
        <button class="btn btn-info btn-fill btn-wd" @click="onClickSubmit">
          {{ client.id === null ? "登録する" : "更新する" }}
        </button>
      </div>
      <!-- /buttons -->
    </div>
    <!-- /.content -->
  </div>
</template>

<script>
  import FileUploader from '~/components/common/file/uploader'

  export default {
    layout: "dashboard",
    components: {
      FileUploader,
    },
    props: {
      client: {
        type: Object,
        'default': () => ({
          id: null,
          name: null,
          address: null,
          url: null,
          note: null,
          labels: [],
        })
      },
      labelOptions: {
        type: Array,
        'default': () => []
      },
      errors: {
        type: Array,
        'default': () => []
      },
    },
    data() {
      return {
        form: {
          id: this.client.id,
          name: this.client.name,
          address: this.client.address,
          url: this.client.url,
          note: this.client.note,
          labels: this.client.labels,
          icon_path: this.client.icon_path,
        },
        need_upload_icon_path: null,
      }
    },
    methods: {
      onClickSubmit() {
        this.$emit('submit', this.form)
      },
      addLabel: function (newLabel) {
        const label = {
          id: newLabel.substring(0, 2) + Math.floor((Math.random() * 10000000)),
          name: newLabel,
        };
        this.labelOptions.push(label);
        this.form.labels.push(label);
      },
      onChangeFile(filePath) {
        this.form.icon_path = filePath
      },
    }
  }
</script>

<style lang="scss" scoped>
  .icon-area {
    text-align: center;
    padding-top: 15px;

    .edit-icon {
      position: relative;
      top: 70px;
      right: 45px;
      cursor: pointer;
      font-size: 20px;
      border-radius: 50%;
      background: #41B883;
      padding: 10px;
      color: #fff;

      &:hover {
        opacity: 0.9;
      }
    }
  }

  .actions {
    margin: 15px auto;
  }

  label.input-file-label > input {
    display: none;
  }
</style>
