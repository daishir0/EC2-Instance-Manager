# EC2-Instance-Manager

## Overview
EC2-Instance-Manager is a web-based tool for managing Amazon EC2 instances. It provides a user-friendly interface to start, stop, force stop, and modify instance types of your EC2 instances across different AWS regions. A key feature is the ability to modify instance types seamlessly within the interface.

## Installation
1. Clone the repository:
   ```
   git clone https://github.com/daishir0/EC2-Instance-Manager.git
   ```
2. Navigate to the project directory:
   ```
   cd EC2-Instance-Manager
   ```
3. Install the required dependencies:
   ```
   composer install
   ```
4. Configure your AWS credentials in the PHP file.
5. Set up your web server (e.g., Apache, Nginx) to serve the PHP files.

## Usage
1. Access the web interface through your browser.
2. You'll see a list of your EC2 instances with their current status and available actions.
3. Use the buttons to start, stop, or force stop instances.
4. To change an instance type:
   - Select the desired type from the dropdown.
   - Click "Modify Type".
   - The system will automatically:
     a) Stop the instance if it's running.
     b) Change the instance type.
     c) Start the instance again.
   - You can monitor the progress directly in the interface.
5. The interface updates automatically every 15 seconds to reflect the current status of your instances.

## Notes
- Ensure that your AWS credentials have the necessary permissions to perform actions on EC2 instances.
- The tool uses Basic Authentication for access control. Make sure to change the default credentials in the PHP file.
- This tool should be deployed in a secure environment, as it contains sensitive AWS credential information.
- The available instance types for modification (t3a.medium and t3a.large) are currently hardcoded in the source. If you need to change these or add more options, you'll need to modify the PHP source code directly.
- The seamless instance type modification process (stop-modify-start) is handled automatically by the JavaScript code. Ensure that this code remains intact for this feature to work properly.

## License
This project is licensed under the MIT License - see the LICENSE file for details.

---

# EC2インスタンスマネージャー

## 概要
EC2インスタンスマネージャーは、Amazon EC2インスタンスを管理するためのWebベースのツールです。異なるAWSリージョンにまたがるEC2インスタンスの起動、停止、強制停止、およびインスタンスタイプの変更を行うためのユーザーフレンドリーなインターフェースを提供します。特筆すべき機能として、インターフェース内でシームレスにインスタンスタイプを変更できる点があります。

## インストール方法
1. リポジトリをクローンします：
   ```
   git clone https://github.com/daishir0/EC2-Instance-Manager.git
   ```
2. プロジェクトディレクトリに移動します：
   ```
   cd EC2-Instance-Manager
   ```
3. 必要な依存関係をインストールします：
   ```
   composer install
   ```
4. PHPファイル内でAWSの認証情報を設定します。
5. WebサーバーPHP（Apache、Nginxなど）をPHPファイルを提供するように設定します。

## 使い方
1. ブラウザからWebインターフェースにアクセスします。
2. EC2インスタンスのリストが表示され、現在のステータスと利用可能なアクションが表示されます。
3. ボタンを使用してインスタンスの起動、停止、強制停止を行います。
4. インスタンスタイプを変更するには：
   - ドロップダウンから希望のタイプを選択します。
   - "Modify Type"をクリックします。
   - システムが自動的に以下を実行します：
     a) インスタンスが起動中の場合、停止します。
     b) インスタンスタイプを変更します。
     c) インスタンスを再起動します。
   - インターフェース上で直接進行状況を監視できます。
5. インターフェースは15秒ごとに自動更新され、インスタンスの現在のステータスを反映します。

## 注意点
- AWSの認証情報がEC2インスタンスに対して必要なアクションを実行するための適切な権限を持っていることを確認してください。
- このツールはアクセス制御のためにBasic認証を使用しています。PHPファイル内のデフォルトの認証情報を変更してください。
- このツールには機密性の高いAWS認証情報が含まれているため、安全な環境にデプロイする必要があります。
- 変更可能なインスタンスタイプ（t3a.mediumとt3a.large）は現在ソースコードにハードコードされています。これらを変更したり、オプションを追加したりする必要がある場合は、PHPのソースコードを直接修正する必要があります。
- シームレスなインスタンスタイプ変更プロセス（停止-変更-起動）はJavaScriptコードによって自動的に処理されます。この機能を正しく動作させるために、このコードを維持してください。

## ライセンス
このプロジェクトはMITライセンスの下でライセンスされています。詳細はLICENSEファイルを参照してください。
