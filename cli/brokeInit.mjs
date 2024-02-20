import fs from 'fs-extra';
import path from 'path';
import inquirer from 'inquirer';
import chalk from 'chalk';
import { exec } from 'child_process';

async function init() {
  console.log(chalk.greenBright("Welcome to BrokeInit! 👋 🚀"));
  console.log(chalk.cyan("Let's set up your project."));

  const answers = await inquirer.prompt([
    {
      name: 'name',
      message: chalk.yellowBright('What is the name of the project?'),
    },
    {
      name: 'local',
      message: chalk.yellowBright('What is the local URL for WordPress?'),
    },
    {
      name: 'production',
      message: chalk.yellowBright('What will be the production URL for WordPress?'),
    },
    {
      type: 'confirm',
      name: 'browserSync',
      message: chalk.yellowBright('Do you want to get started with BrowserSync?'),
      default: false,
    }
  ]);

  console.log(chalk.blue(`\nCreating configuration for ${chalk.bold(answers.name)}...`));

  const configData = {
    name: answers.name,
    local: answers.local,
    production: answers.production,
    docs: "https://broke.dev/theme/docs",
    tutorial: "YOUTUBE_URL_HERE"
  };

  await fs.writeJson(path.join(process.cwd(), 'cli', 'broke.json'), configData, { spaces: 2 });
  console.log(chalk.green('Configuration saved successfully.'));

  if (answers.browserSync) {
    const sampleConfigPath = path.join(process.cwd(), 'cli', 'browsersync.sample-config.js');
    let configContent = await fs.readFile(sampleConfigPath, 'utf8');
    configContent = configContent.replace('http://site.local', answers.local);
    await fs.writeFile(path.join(process.cwd(), 'browsersync.config.js'), configContent, 'utf8');
    console.log(chalk.green('BrowserSync configuration initialized.'));
  }

  const nextStep = await inquirer.prompt([
    {
      type: 'list',
      name: 'next',
      message: chalk.magenta('What would you like to do next?'),
      choices: [
        'Create a block',
        'Create a layout',
        'Read Docs',
        'Watch Tutorial'
      ],
    }
  ]);

  switch (nextStep.next) {
    case 'Create a block':
      console.log(chalk.yellow('Initializing block creation...'));
      exec('node ./cli/createBlock.mjs', (error, stdout, stderr) => {
        if (error) {
          console.error(chalk.red(`exec error: ${error}`));
          return;
        }
        console.log(stdout);
        console.error(stderr);
      });
      break;
    case 'Create a layout':
      console.log(chalk.yellow('Initializing layout creation...'));
      exec('node ./cli/createLayout.mjs', (error, stdout, stderr) => {
        if (error) {
          console.error(chalk.red(`exec error: ${error}`));
          return;
        }
        console.log(stdout);
        console.error(stderr);
      });
      break;
    case 'Read Docs':
      console.log(chalk.blue('Visit the documentation at ') + chalk.underline.blueBright("https://broke.dev/theme/docs"));
      break;
    case 'Watch Tutorial':
      console.log(chalk.blue('Watch the tutorial at ') + chalk.underline.blueBright("YOUTUBE_URL_HERE"));
      break;
  }
}

init().catch(error => console.error(chalk.redBright(`An error occurred: ${error}`)));
