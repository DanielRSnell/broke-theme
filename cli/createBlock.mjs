import fs from 'fs-extra';
import path from 'path';
import inquirer from 'inquirer';
import chalk from 'chalk';

async function loadCategories() {
  const categoriesPath = path.join(process.cwd(), 'theme', 'blocks', 'categories.json');
  try {
    if (await fs.pathExists(categoriesPath)) {
      return await fs.readJson(categoriesPath);
    } else {
      console.warn(chalk.yellow('⚠️ Warning: categories.json file not found.'));
    }
  } catch (error) {
    console.error(chalk.red(`Error reading categories.json: ${error}`));
  }
  return [];
}

async function loadBrokeConfig() {
  const brokeConfigPath = path.join(process.cwd(), 'cli', 'broke.json');
  try {
    if (await fs.pathExists(brokeConfigPath)) {
      return await fs.readJson(brokeConfigPath);
    } else {
      console.warn(chalk.yellow('⚠️ Warning: broke.json configuration file not found. Some functionalities might be limited.'));
    }
  } catch (error) {
    console.error(chalk.red(`Error reading broke.json: ${error}`));
  }
  return null;
}

async function createBlock() {
  console.log(chalk.greenBright('🚀 Starting the Block Creation Wizard...'));
  const brokeConfig = await loadBrokeConfig();
  const categories = await loadCategories();

  let continueCreating = true;

  while (continueCreating) {
    // console.log(brokeConfig);
    const answers = await inquirer.prompt([
      {
        name: 'blockName',
        message: chalk.yellow('What is the name of the block?'),
        default: 'my-block'
      },
      {
        type: 'list',
        name: 'category',
        message: 'Select a category for the block:',
        choices: categories.map(category => ({ name: category.title, value: category.slug })),
      }
    ]);

    const { blockName, category } = answers;
    const sourceDir = path.join(process.cwd(), 'cli', '[block]');
    const targetDir = path.join(process.cwd(), 'theme', 'blocks', blockName);

    try {
      await fs.copy(sourceDir, targetDir);

      const files = await fs.readdir(targetDir);
      for (const file of files) {
        const filePath = path.join(targetDir, file);
        let newFilePath = filePath.includes('[block]') ? filePath.replace('[block]', blockName) : filePath;
        newFilePath = newFilePath.includes('[category]') ? newFilePath.replace('[category]', category) : newFilePath; // Replace [category] with the selected category's slug
        if (filePath !== newFilePath) {
          await fs.rename(filePath, newFilePath);
        }

        let content = await fs.readFile(newFilePath, 'utf8');
        content = content.replace(/\[block\]/g, blockName);
        content = content.replace(/\[block-name\]/g, blockName.toLowerCase().replace(/\s+/g, '-'));
        content = content.replace(/\[block_name\]/g, blockName.toLowerCase().replace(/\s+/g, '_'));
        content = content.replace(/\[category\]/g, category); // Replace [category] placeholders
        await fs.writeFile(newFilePath, content, 'utf8');
      }

      console.log(chalk.green(`✨ Block creation for '${chalk.bold(blockName)}' completed successfully.`));

      if (brokeConfig && brokeConfig.local) {
        console.log(chalk.blue(`📘 Now, go to ${chalk.underline(`${brokeConfig.local}/wp-admin/edit.php?post_type=acf-field-group`)} to create an ACF Field Group for '${blockName}'.`));
        console.log(chalk.blue(`🔗 Attach it to the '${blockName}' block which is already registered.`));
      }
    } catch (error) {
      console.error(chalk.red('An error occurred:'), error);
    }

    // Ask if the user wants to create another block
    const repeat = await inquirer.prompt([
      {
        name: 'again',
        type: 'confirm',
        message: 'Do you want to create another block?',
        default: false,
      },
    ]);

    continueCreating = repeat.again;
  }

  console.log(chalk.blue('Thank you for using the Block Creation Wizard. Goodbye!'));
}

createBlock().catch(error => console.error(chalk.redBright(`An error occurred: ${error}`)));
