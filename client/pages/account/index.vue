<template>
  <div id="account">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <!-- .header -->
          <div class="header">
            <h4 class="title">アカウント設定</h4>
          </div>
          <!-- /.header -->
          <!-- .content -->
          <div class="content">
            <!-- .form -->
            <div class="form">
              <div class="row">
                <!-- .icon-area -->
                <div class="icon-area">
                  <img
                    :src="$utility.getImageUrl(user.icon_path)"
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
                <div class="col-md-8 col-md-offset-2">
                  <fg-input
                    type="text"
                    label="Name"
                    placeholder="ユーザー名"
                    v-model="user.name"
                    :errors="errors.name"
                  >
                  </fg-input>
                  <fg-input
                    type="email"
                    label="email"
                    placeholder="メールアドレス"
                    v-model="user.email"
                    :errors="errors.email"
                  >
                  </fg-input>
                  <fg-input
                    type="password"
                    label="Password"
                    placeholder="パスワード"
                    v-model="user.password"
                    :errors="errors.password"
                  >
                  </fg-input>
                </div>
              </div>
              <!-- button -->
              <div class="text-center">
                <button class="btn btn-info btn-fill btn-wd" @click="update">
                  更新する
                </button>
              </div>
              <!-- /button -->
            </div>
            <!-- /.form -->
          </div>
          <!-- /.content -->
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import FileUploader from '~/components/common/file/uploader'
  import cloneDeep from 'lodash.clonedeep'

  /**
   * アカウント設定画面
   */
  export default {
    layout: 'default',
    components: {
      FileUploader,
    },
    head() {
      return {
        title: 'アカウント設定',
      }
    },
    data () {
      return {
        user: cloneDeep(this.$auth.user),
        errors: [],
      }
    },
    methods: {
      async update () {
        if (this.$utility.chkCanEdit(this.$notifications, this.$auth.user)) {
          await this.$axios.$put(`/auth/update/${this.user.id}`, this.user)
            .then((response) => {
              this.errors = [];
              this.$auth.setUser(response.user);
              this.$utility.notifySuccess(this.$notifications, '更新が完了しました');
            })
            .catch((err) => {
              let errorMessage = null;
              if (err.response.status === 422) {
                this.errors = err.response.data;
                errorMessage = '入力項目をご確認ください';
              }
              this.$utility.notifyError(this.$notifications, errorMessage);
            });
        }
      },
      onChangeFile(filePath) {
        this.user.icon_path = filePath
      },
    }
  }
</script>

<style lang="scss" scoped>
  #account {
    .form {
      padding: 15px;
      color: #03bc06;
    }

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
  }
</style>
