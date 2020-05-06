import https from 'https';

export default ({ $axios }) => {
  $axios.defaults.httpsAgent = new https.Agent({ rejectUnauthorized: false });
  $axios.onError(error => {
    console.log(error);
    // if (error.response.status === 401) {
    //   window.location.href = '/login';
    // }
  });
}
