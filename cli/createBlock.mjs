import fs from 'fs-extra';
import path from 'path';
import inquirer from 'inquirer';
import chalk from 'chalk';

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
  console.log(brokeConfig);
  const answers = await inquirer.prompt([
    {
      name: 'blockName',
      message: chalk.yellow('What is the name of the block?'),
      default: 'my-block'
    }
  ]);

  const blockName = answers.blockName;
  const sourceDir = path.join(process.cwd(), 'cli', '[block]');
  const targetDir = path.join(process.cwd(), 'theme', 'blocks', blockName);

  try {
    await fs.copy(sourceDir, targetDir);

    const files = await fs.readdir(targetDir);
    for (const file of files) {
      const filePath = path.join(targetDir, file);
      const newFilePath = filePath.includes('[block]') ? filePath.replace('[block]', blockName) : filePath;
      if (filePath !== newFilePath) {
        await fs.rename(filePath, newFilePath);
      }

      let content = await fs.readFile(newFilePath, 'utf8');
      content = content.replace(/\[block\]/g, blockName);
      content = content.replace(/\[block-name\]/g, blockName.toLowerCase().replace(/\s+/g, '-'));
      await fs.writeFile(newFilePath, content, 'utf8');
    }

    console.log(chalk.green(`✨ Block creation for '${chalk.bold(blockName)}' completed successfully.`));

    // Use brokeConfig for local URL if available
    if (brokeConfig && brokeConfig.local) {
      console.log(chalk.blue(`📘 Now, go to ${chalk.underline(`${brokeConfig.local}/wp-admin/edit.php?post_type=acf-field-group`)} to create an ACF Field Group for '${blockName}'.`));
      console.log(chalk.blue(`🔗 Attach it to the '${blockName}' block which is already registered.`));
    }
  } catch (error) {
    console.error(chalk.red('An error occurred:'), error);
  }
}

createBlock().catch(error => console.error(chalk.redBright(`An error occurred: ${error}`)));
