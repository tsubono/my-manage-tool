import axios from 'axios'
import {notify} from '~/components/UIComponents/NotificationPlugin';

class Utility {
  constructor (axios, store) {
    this.$axios = axios;
    this.$store = store;
  }

  /**
   * 編集権限チェック
   * NGの場合はnotify表示
   *
   * @param notifications
   * @param user
   * @returns {boolean}
   */
  chkCanEdit = (notifications, user) => {
    if (!user.can_edit) {
      notifications.notify(
        {
          message: '<h4>Sorry...</h4><p>編集権限がありません</p>',
          icon: 'ti-face-sad',
          horizontalAlign: 'right',
          verticalAlign: 'bottom',
          type: 'danger',
        });
      return false;
    }
    return true;
  };

  /**
   * セレクトボックス用の取引先一覧を取得
   *
   * @param clients
   * @returns {Array}
   */
  getClientOptions = (clients) => {
    let options = [];
    clients.map(client => {
      options.push({id: client.id, name: client.name});
    });
    return options;
  };

  /**
   * セレクトボックス用の案件一覧を取得
   *
   * @param projects
   * @returns {Array}
   */
  getProjectOptions = (projects) => {
    let options = [];
    projects.map(project => {
      options.push({id: project.id, name: project.name});
    });
    return options;
  };

  /**
   * セレクトボックス用のステータス一覧を取得
   *
   * @param statuses
   * @returns {Array}
   */
  getStatusOptions = (statuses) => {
    let options = [];
    statuses.map(status => {
      options.push({id: status.id, name: status.name});
    });
    return options;
  };

  /**
   * セレクトボックス用の外注先一覧を取得
   *
   * @param subcntractors
   * @returns {Array}
   */
  getSubcontractorOptions = (subcntractors) => {
    let options = [];
    subcntractors.map(subcntractor => {
      options.push({id: subcntractor.id, name: subcntractor.name});
    });
    return options;
  };

  /**
   * imgタグ用の画像URLを取得
   * process.env.APP_URL = ApiのURL
   *
   * @param path
   * @returns {string}
   */
  getImageUrl = (path) => {
    return path ? path : 'https://my-manage-tool.s3-ap-northeast-1.amazonaws.com/files/common/img/icon-no-image.png';
  };

  /**
   * エラーを表示する
   *
   * @param notifications
   * @param message
   */
  notifyError = (notifications, message = null) => {
    notifications.notify(
      {
        message: `<h4>Error</h4><p>${message !== null ? message : 'システムエラーが発生しました'}</p>`,
        icon: 'ti-bolt-alt',
        horizontalAlign: 'right',
        verticalAlign: 'bottom',
        type: 'warning',
      });
  };

  /**
   * 成功メッセージを表示する
   *
   * @param notifications
   * @param message
   */
  notifySuccess = (notifications, message = null) => {
    notifications.notify(
      {
        message: `<h4>Success</h4><p>${message !== null ? message : '処理が完了しました'}</p>`,
        icon: 'ti-face-smile',
        horizontalAlign: 'right',
        verticalAlign: 'bottom',
        type: 'success',
      });
  }
}

export default ({ store }, inject) => {
  inject('utility', new Utility(axios, store))
}
