import autoprefixer from 'autoprefixer';

const plugins = {
  plugins: [
    autoprefixer(
      {
        overrideBrowserslist: ['last 3 versions', 'ie > 9']
      }
    )
  ]
}

export default plugins;
