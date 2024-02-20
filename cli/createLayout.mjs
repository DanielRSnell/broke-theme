import fs from 'fs-extra';
import path from 'path';
import inquirer from 'inquirer';
import chalk from 'chalk';

async function createLayout() {
  console.log(chalk.greenBright('Welcome to the Layout Creator! 🎨🛠️'));

  const cliDir = path.join(process.cwd(), 'cli');
  const layoutsDir = path.join(process.cwd(), 'theme', 'layouts');

  const brokeConfigPath = path.join(cliDir, 'broke.json');
  if (!await fs.pathExists(brokeConfigPath)) {
    console.error(chalk.red('Error: broke.json configuration file not found.'));
    return;
  }
  const brokeConfig = await fs.readJson(brokeConfigPath);

  const { layoutGroupChoice } = await inquirer.prompt([
    {
      type: 'list',
      name: 'layoutGroupChoice',
      message: 'Is this for an existing layout group or a new layout group?',
      choices: ['Existing', 'New']
    }
  ]);

  let groupDir, groupName;

  if (layoutGroupChoice === 'New') {
    const { newGroupName } = await inquirer.prompt([
      {
        type: 'input',
        name: 'newGroupName',
        message: 'Enter the new group name:',
        validate: input => input.trim() === '' ? 'Group name cannot be empty.' : true
      }
    ]);
    groupName = newGroupName.toLowerCase().replace(/\s+/g, '_');
    groupDir = path.join(layoutsDir, groupName);
    await fs.ensureDir(groupDir);

    // Copy the group template
    const groupTemplateDir = path.join(cliDir, '[group]');
    if (await fs.pathExists(groupTemplateDir)) {
      await fs.copy(groupTemplateDir, groupDir);
    }
  } else {
    const directories = await fs.readdir(layoutsDir, { withFileTypes: true });
    const dirChoices = directories.filter(dirent => dirent.isDirectory()).map(dirent => dirent.name);

    const { selectedDir } = await inquirer.prompt([
      {
        type: 'list',
        name: 'selectedDir',
        message: 'Choose an existing layout group:',
        choices: dirChoices
      }
    ]);
    groupName = selectedDir;
    groupDir = path.join(layoutsDir, groupName);
  }

  const { layoutName } = await inquirer.prompt([
    {
      type: 'input',
      name: 'layoutName',
      message: 'What is the name of the layout?',
      default: 'new-layout'
    }
  ]);

  const layoutDirName = layoutName.toLowerCase().replace(/\s+/g, '_');
  const layoutTemplateDir = path.join(cliDir, '[layout]');
  const targetLayoutDir = path.join(groupDir, layoutDirName);

  // Copy the layout template to the target directory
  if (await fs.pathExists(layoutTemplateDir)) {
    await fs.copy(layoutTemplateDir, targetLayoutDir);

    // Replace [layout] placeholders
    const replacePlaceholders = async (dir) => {
      const files = await fs.readdir(dir);
      for (const file of files) {
        const filePath = path.join(dir, file);
        if ((await fs.stat(filePath)).isDirectory()) {
          await replacePlaceholders(filePath); // Recursive call for nested directories
        } else {
          let content = await fs.readFile(filePath, 'utf8');
          content = content.replace(/\[layout\]/g, layoutDirName);
          await fs.writeFile(filePath, content, 'utf8');
        }
      }
    };

    await replacePlaceholders(targetLayoutDir);
    console.log(chalk.green(`Layout "${layoutName}" created successfully within "${groupName}".`));
  } else {
    console.error(chalk.red('Layout template directory does not exist.'));
    return;
  }

  // Instructions for ACF Field Group
  const acfUrl = `${brokeConfig.local}/wp-admin/edit.php?post_type=acf-field-group`;
  console.log(chalk.blue(`\nNext steps for ACF setup:`));
  if (layoutGroupChoice === 'New') {
    console.log(chalk.blue(`1. Go to ${chalk.underline(acfUrl)} and create a new field group for "${groupName}".`));
    console.log(chalk.blue(`2. Add a "Flexible Content" field named "${layoutDirName}" within this group.`));
  } else {
    console.log(chalk.blue(`1. Go to ${chalk.underline(acfUrl)}, find and edit the "${groupName}" field group.`));
    console.log(chalk.blue(`2. Add a new layout named "${layoutDirName}" to the existing "Flexible Content" field.`));
  }
}

createLayout().catch(error => console.error(chalk.redBright(`An error occurred: ${error}`)));
